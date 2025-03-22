<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UseZoom;
use App\Models\Appointment;
use App\Models\Course;
use App\Models\Meeting;
use App\Models\Topic;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ZoomController extends Controller
{
    use UseZoom;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function createZoomLink($request)
    {

        $data = $this->create($request);

        return $data;
    }


    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_guid' => 'required|string|max:100',
            'description' => 'required|string',
            'meeting_link' => 'nullable|string',
            'password' => 'nullable|string',
            'type' => 'required|in:true,false,1,0',
            'time_start' => 'required|date_format:Y-m-d\TH:i',
            'time_end' => 'required|date_format:Y-m-d\TH:i|after:' . $request['time_start'],
            'id' => 'nullable|string',
            'link' => 'nullable|string',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        // Ambil nama topik berdasarkan topic_guid
        $topic = Topic::where('guid', $request['topic_guid'])->first();
        if (!$topic) {
            return ResponseController::getResponse(null, 404, 'Topic not found');
        }

        // Data awal untuk disimpan
        $data = [
            'topic_guid' => $request['topic_guid'],
            'description' => $request['description'],
            'time_start' => $request['time_start'],
            'time_end' => $request['time_end'],
            'is_manual_link' => filter_var($request['type'], FILTER_VALIDATE_BOOLEAN),
        ];

        // Jika `type` FALSE (manual), gunakan data yang dikirim dari request
        if (filter_var($request['type'], FILTER_VALIDATE_BOOLEAN) == 0) {
            $data['meeting_id'] = $request['id'] ?? null;
            $data['meeting_password'] = $request['password'] ?? null;
            $data['link'] = $request['link'] ?? null;
        } else {
            // Jika `type` TRUE (otomatis), buat meeting di Zoom
            $zoomData = [
                'topic' => $topic->name,  // Gunakan nama topik
                'time_start' => $request['time_start'],
                'duration' => $this->calculateDuration($request['time_start'], $request['time_end']),
                'description' => $request['description'],
            ];

            // Panggil fungsi untuk membuat meeting di Zoom
            $zoomResponse = $this->createZoomMeeting((object) $zoomData);

            if (!$zoomResponse['success']) {
                return ResponseController::getResponse(null, 500, 'Failed to create Zoom meeting');
            }

            // Simpan data Zoom jika berhasil
            $data['meeting_id'] = $zoomResponse['data']['id'];
            $data['meeting_password'] = $zoomResponse['data']['password'];
            $data['link'] = $zoomResponse['data']['join_url'];
        }

        // Simpan meeting ke database
        $meeting = Meeting::create($data);

        return ResponseController::getResponse($meeting, 200, 'Success');
    }




    public function showData()
    {
        $userId = auth('api')->user()->id;
        $roleName = auth('api')->user()->role->role_name;

        if ($roleName == "admin") {
            // Jika admin, tampilkan semua data
            $userCourses = Course::pluck('code')->toArray();
        } else {
            $userCourses = UserCourse::where('user_id', $userId)
                ->pluck('course_code')
                ->toArray();
        }

        // Ambil semua topic berdasarkan course_code user
        $topics = Topic::whereIn('course_code', $userCourses)
            ->with('course') // Ambil relasi course
            ->get();

        // Ambil semua topic_guid dari topic yang sudah ditemukan
        $topicGuids = $topics->pluck('guid')->toArray();

        // Ambil data meeting berdasarkan topic_guid
        $meetings = Meeting::whereIn('topic_guid', $topicGuids)
            ->with(['topic', 'topic.course']) // Load relasi topic dan course
            ->get();

        // Gabungkan semua meetings dengan informasi topik dan kursus
        $allData = $meetings->map(function ($meeting) {
            $now = Carbon::now();
            $startTime = Carbon::parse($meeting->time_start);
            $endTime = Carbon::parse($meeting->time_end);

            if ($now->lessThan($startTime)) {
                $status = 'Upcoming'; // Belum mulai
            } elseif ($now->between($startTime, $endTime)) {
                $status = 'Ongoing'; // Sedang berlangsung
            } else {
                $status = 'Expired'; // Sudah selesai
            }

            return [
                'guid'         => $meeting->guid,
                'topic_guid'   => $meeting->topic->topic_guid,
                'topic_name'   => $meeting->topic->name,
                'course_code'  => $meeting->topic->course->course_code,
                'course_name'  => $meeting->topic->course->name,
                'description'  => $meeting->description,
                'time_start'   => $meeting->time_start,
                'time_end'     => $meeting->time_end,
                'link'         => $meeting->link,
                'meeting_id'   => $meeting->meeting_id,
                'meeting_password' => $meeting->meeting_password,
                'type' => $meeting->is_manual_link,
                'status'       => $status,
            ];
        });

        // Konversi ke DataTables
        return DataTables::of($allData)
            ->addIndexColumn()
            ->make(true);
    }

    public function getData($guid)
    {
        // Ambil data meeting beserta relasi topic dan course
        $meeting = Meeting::with(['topic', 'topic.course'])
            ->where('guid', $guid)
            ->first();

        // Jika meeting tidak ditemukan, return response error
        if (!$meeting) {
            return ResponseController::getResponse(null, 400, 'Data not found');
        }


        // Format output agar sesuai dengan showData
        $data = [
            'guid'            => $meeting->guid,
            'topic_guid'      => $meeting->topic->guid,
            'topic_name'      => $meeting->topic->name,
            'course_code'     => $meeting->topic->course->code,
            'course_name'     => $meeting->topic->course->name,
            'description'     => $meeting->description,
            'time_start'      => $meeting->time_start,
            'time_end'        => $meeting->time_end,
            'link'            => $meeting->link,
            'meeting_password' => $meeting->meeting_password,
            'meeting_id' => $meeting->meeting_id,
            'type' => $meeting->is_manual_link,
        ];

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function meetingByDeadline(Request $request)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $userId = $request['id'];
        $currentDateTime = Carbon::now('Asia/Jakarta');

        // Ambil semua course_code yang dimiliki user
        $userCourses = UserCourse::where('user_id', $userId)
            ->pluck('course_code')
            ->toArray();

        // Ambil semua topic_guid berdasarkan course_code user
        $topicGuids = Topic::whereIn('course_code', $userCourses)
            ->pluck('topic_guid')
            ->toArray();

        // Ambil meeting berdasarkan topic_guid dan deadline
        $meetings = Meeting::whereIn("topic_guid", $topicGuids)
            ->where('time_end', '>', $currentDateTime)
            ->where('time_start', '<=', $currentDateTime)
            ->with(['topic.course']) // Ambil relasi topic dan course
            ->get();

        // Format data sesuai permintaan
        $formattedMeetings = $meetings->map(function ($meeting) {
            return [
                'guid'             => $meeting->guid,
                'topic_guid'       => $meeting->topic->topic_guid,
                'topic_name'       => $meeting->topic->name,
                'course_code'      => $meeting->topic->course->course_code,
                'course_name'      => $meeting->topic->course->name,
                'description'      => $meeting->description,
                'time_start'       => $meeting->time_start,
                'time_end'         => $meeting->time_end,
                'link'             => $meeting->link,
                'meeting_password' => $meeting->meeting_password,
            ];
        });

        // Jika data kosong, return response error
        if ($formattedMeetings->isEmpty()) {
            return ResponseController::getResponse(null, 400, "No meetings found");
        }

        // Return data dalam format DataTables
        return DataTables::of($formattedMeetings)
            ->addIndexColumn()
            ->make(true);
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guid' => 'required|string|max:100',
            'topic_guid' => 'required|string|max:100',
            'description' => 'required|string',
            'meeting_link' => 'nullable|string',
            'meeting_id' => 'nullable|string',
            'password' => 'nullable|string',
            'time_start' => 'required|date_format:Y-m-d\TH:i',
            'time_end' => 'required|date_format:Y-m-d\TH:i|after:' . $request['time_start'],
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Meeting::where('guid', '=', $request['guid'])->with('topic')->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        // Simpan data sebelum update untuk membandingkan
        $oldData = $data->toArray();

        /// UPDATE DATA
        $data->topic_guid = $request['topic_guid'];
        $data->description = $request['description'];
        $data->time_start = $request['time_start'];
        $data->time_end = $request['time_end'];

        if (!$data->is_manual_link) {
            // Jika manual, gunakan data dari request tanpa update Zoom
            $data->meeting_id = $request['meeting_id'];
            $data->meeting_password = $request['password'];
            $data->link = $request['meeting_link'];
        } else {
            // Jika otomatis, cek apakah ada perubahan data yang relevan untuk Zoom
            if (
                $oldData['topic_guid'] !== $data->topic_guid ||
                $oldData['time_start'] !== $data->time_start ||
                $oldData['time_end'] !== $data->time_end ||
                $oldData['description'] !== $data->description
            ) {
                $zoomData = [
                    'topic' => $data->topic->name,
                    'start_time' => $data->time_start,
                    'duration' => $this->calculateDuration($data->time_start, $data->time_end),
                    'agenda' => $data->description,
                ];

                $zoomResponse = $this->updatezoom($data->meeting_id, $zoomData);

                if (!$zoomResponse['success']) {
                    return ResponseController::getResponse(null, 500, 'Failed to update Zoom meeting');
                }
            }
        }

        $data->save();
        return ResponseController::getResponse($data, 200, 'Success');
    }


    public function deleteData($guid)
    {
        $data = Meeting::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        // Jika bukan manual link (is_manual_link = true), hapus dari Zoom
        if ($data->is_manual_link) {
            if (!empty($data->meeting_id)) {
                $zoomResponse = $this->deleteZoomMeeting($data->meeting_id);

                if (!$zoomResponse['success']) {
                    return ResponseController::getResponse(null, 500, "Failed to delete Zoom meeting");
                }
            }
        }

        // Hapus dari database
        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }


    public function bulkDeleteMeetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $meetings = Meeting::whereIn('guid', $request->guids)->get();
        $failedDeletions = [];

        foreach ($meetings as $meeting) {
            // Jika meeting adalah otomatis (is_manual_link = true), hapus dari Zoom terlebih dahulu
            if ($meeting->is_manual_link) {
                if (!empty($meeting->meeting_id)) {
                    $zoomResponse = $this->deleteZoomMeeting($meeting->meeting_id);

                    if (!$zoomResponse['success']) {
                        $failedDeletions[] = $meeting->guid;
                        continue; // Jika gagal dihapus dari Zoom, lewati penghapusan database
                    }
                }
            }

            // Hapus dari database
            $meeting->delete();
        }

        if (!empty($failedDeletions)) {
            return response()->json([
                'error' => 'Some Zoom meetings failed to delete',
                'failed_guids' => $failedDeletions
            ], 500);
        }

        return response()->json([
            'message' => count($meetings) . " meetings deleted successfully.",
        ], 200);
    }
}
