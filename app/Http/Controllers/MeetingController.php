<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\ZoomService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    private $zoomController;
    protected $zoomService;

    public function __construct(ZoomController $zoomController, ZoomService $zoomService)
    {
        $this->zoomController = $zoomController;
        $this->zoomService = $zoomService; // Assign ZoomService to the controller property
    }

    // Method to render the view to create a meeting
    public function create()
    {
        return view('meetings.create');
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
                'password' => $zoomMeeting->password,
                'start_time' => $request->start_time,
                'join_url' => $zoomMeeting->join_url,
                
            ]);
    
            return redirect()->route('meetings.index')->with('message', 'Meeting created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create meeting: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create meeting: ' . $e->getMessage());
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


    public function join($meetingId)
    {
        $meeting = Meeting::where('meeting_id', $meetingId)->firstOrFail();
        $signature = $this->zoomService->createSignature($meeting->meeting_id, 0);

        return view('meetings.join', [
            'meeting' => $meeting,
            'signature' => $signature,
        ]);
    }

   
    // Display the list of meetings
    public function index()
    {
        $meetings = Meeting::where('user_id', Auth::id())->get();
        return view('meetings.index', compact('meetings'));
    }

    // Display the list of meetings for students
    public function studentIndex()
    {
        $meetings = Meeting::all();
        return view('meetings.student_index', compact('meetings'));
    }
}
