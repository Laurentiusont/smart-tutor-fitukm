<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\ZoomService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class MeetingController extends Controller
{
    private $zoomController;
    protected $zoomService;

    public function __construct(ZoomController $zoomController, ZoomService $zoomService)
    {
        $this->zoomController = $zoomController;
        $this->zoomService = $zoomService; // Assign ZoomService to the controller property
    }


    // Store a new meeting
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
        ]);
    
        Log::info('Attempting to create meeting with data:', $request->all());
    
        try {
            $user = Auth::user();
            Log::info($user);
            $zoomUserId = $user->zoom_user_id;
    
            if (!$zoomUserId) {
                return redirect()->back()->with('error', 'Zoom User ID not configured.');
            }
    
            $client = new Client();
            $response = $client->post("https://api.zoom.us/v2/users/{$zoomUserId}/meetings", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $user->zoom_access_token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'topic' => $request->topic,
                    'type' => 2,
                    'start_time' => $request->start_time,
                    'duration' => 30,
                    'timezone' => config('app.timezone'),
                ],
            ]);
    
            $zoomMeeting = json_decode($response->getBody());
    
            Log::info('Zoom meeting created successfully:', (array) $zoomMeeting);

            Meeting::create([
                'user_id' => $user->id,
                'meeting_id' => $zoomMeeting->id,
                'topic' => $request->topic,
                'role' => 1,
                'password' => $zoomMeeting->password,
                'start_time' => $request->start_time,
                'join_url' => $zoomMeeting->join_url,
                
            ]);
    
            return ResponseController::getResponse(null, 200, 'Success');
        } catch (\Exception $e) {
            Log::error('Failed to create meeting: ' . $e->getMessage());
            return ResponseController::getResponse(null, 400, "Data not found");
        }
    }
    

    // Centralized function to make a Zoom API call
    private function makeZoomRequest($endpoint, $method = 'GET', $data = [])
    {
        $user = Auth::user();

        $response = Http::withToken($user->zoom_access_token)->$method("https://api.zoom.us/v2/{$endpoint}", $data);

        if ($response->failed()) {
            Log::error("Zoom API request failed: " . $response->body());
        }

        return $response->json();
    }

   // Join a meeting and pass the signature to the view
    public function generateSignature(Request $request)
    {
        Log::info('Request to generate signature', $request->all()); // Log incoming request

        $request->validate([
            'meetingNumber' => 'required|string',
            'role' => 'required'
        ]);

        $meetingNumber = $request->input('meetingNumber');
        $role = $request->input('role');

        // Log the meeting number and role before generating the signature
        Log::info('Generating signature for Meeting Number: ' . $meetingNumber . ' with Role: ' . $role);

        $signature = $this->zoomService->createSignature($meetingNumber, $role);
        return response()->json(['signature' => $signature]);
    }

    public function join($meetingId,Request $request)
    {
        $meeting = Meeting::where('meeting_id', $meetingId)->firstOrFail();
        $signature = $this->zoomService->createSignature($meeting->meeting_id, 0);
        $userId = $request->query('user_id');
        $userEmail = $request->query('user_email');

        // Validasi input
        if (!$userId || !$userEmail) {
            return response()->json([
                'message' => 'User ID or Email is missing.',
                'code' => 400,
            ], 400);
        }
        // Redirect to Frontend with required parameters
        $frontendUrl = 'http://localhost:8000/join';
        return redirect()->away(
            $frontendUrl . '?' . http_build_query([
                'meeting_id' => $meeting->meeting_id,
                'password' => $meeting->password,
                'role' => $meeting->role,
                'user_name' => $userId,
                'user_email' => $userEmail,
                'signature' => $signature,
            ])
        );
    }


    public function showData(Request $request)
    {
        $data = Meeting::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
}
