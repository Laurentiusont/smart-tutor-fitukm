<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Class SyncsWithFirebase
 * @package App\Traits
 */
trait UseZoom
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {


        $this->client = new Client();
        $this->accessToken = '9EAv4Xi3QxiKDINdfZNwog';

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * Display a generateZoomToken.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function generateZoomToken()
    {
        return JWT::generateToken(
            [
                'iss' => config('zoom.api_key'),
                'exp' => time() + config('zoom.token_life')
            ],
            config('zoom.api_secret')
        );
    }*/



    function generateZoomAccessToken()
    {
        $apiKey = env('CLIENT_ID');
        $apiSecret = env('CLIENT_SECRET');
        $account_id = env('ACCOUNT_ID');

        $base64Credentials = base64_encode("$apiKey:$apiSecret");

        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $account_id;

        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials",
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($url);

        $responseData = $response->json();

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            // Log or print the entire response for debugging purposes.
            Log::error('Zoom OAuth Token Response: ' . json_encode($responseData));

            // Handle the error as needed.
            return null; // You might want to return null or throw an exception here.
        }
    }
    /**
     * Display a zoomRequest.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function zoomRequest()
    {
        $token = $this->generateZoomToken();

        return \Illuminate\Support\Facades\Http::withHeaders([
            //'authorization' => 'Bearer ' . $token,
            //'content-type' => 'application/json',
        ]);
    }*/

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());

            return '';
        }
    }

    public function createZoomMeeting($meetingData)
    {
        // Dapatkan token akses Zoom
        $accessToken = $this->generateZoomAccessToken();

        // Tentukan URL API untuk membuat meeting Zoom (gunakan 'me' untuk user yang sedang autentikasi)
        $url = 'https://api.zoom.us/v2/users/me/meetings';  // Ganti dengan 'me'

        // Siapkan data untuk meeting Zoom
        $response = Http::withToken($accessToken)->post($url, [
            'topic'      => $meetingData->topic, // Gunakan data dari database
            'type'       => 2, // Tipe 2 berarti meeting terjadwal
            'start_time' => $meetingData->time_start, // Gunakan waktu mulai dari input
            'duration'   => $meetingData->duration,
            'agenda'     => $meetingData->description, // Deskripsi meeting
            'timezone'   => 'Asia/Jakarta', // Ganti zona waktu ke Jakarta
        ]);

        // Cek apakah API Zoom berhasil
        if ($response->successful()) {
            return [
                'success' => true,
                'data'    => json_decode($response->getBody(), true), // Mengembalikan data meeting Zoom
            ];
        }

        // Jika gagal, kembalikan false dan data error
        return [
            'success' => false,
            'data'    => json_decode($response->getBody(), true),
        ];
    }


    // Fungsi untuk menghitung durasi meeting berdasarkan waktu mulai dan selesai
    private function calculateDuration($startTime, $endTime)
    {
        $start = \Carbon\Carbon::parse($startTime);
        $end = \Carbon\Carbon::parse($endTime);
        return $start->diffInMinutes($end); // Durasi dalam menit
    }


    public function updatezoom($id, $data)
    {
        $accessToken = $this->generateZoomAccessToken();
        $url = 'https://api.zoom.us/v2/meetings/' . $id;

        $response = Http::withToken($accessToken)->patch($url, [
            'topic'      => $data['topic'], // Gunakan topic dari data
            'type'       => 2, // Scheduled meeting
            'start_time' => $this->toZoomTimeFormat($data['start_time']), // Format sesuai Zoom
            'duration'   => $data['duration'], // Gunakan durasi dari perhitungan
            'agenda'     => $data['agenda'] ?? null, // Pakai agenda jika ada
            'timezone'   => 'Asia/Jakarta', // Pastikan timezone sesuai dengan lokasi
        ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } else {
            return [
                'success' => false,
                'error'   => $response->json(),
            ];
        }
    }



    public function get($id)
    {
        $path = 'meetings/' . $id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->get($url . $path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */

    public function deleteZoomMeeting($id)
    {
        $accessToken = $this->generateZoomAccessToken();
        $url = 'https://api.zoom.us/v2/meetings/' . $id;

        $response = Http::withToken($accessToken)->delete($url);

        if ($response->successful()) {
            // Meeting deleted successfully
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } else {
            // Handle the error
            return response()->json(['error' => 'Failed to delete the Zoom meeting'], 500);
        }
    }


    public function zoomRequest()
    {
        $token = $this->generateZoomAccessToken();

        return \Illuminate\Support\Facades\Http::withHeaders([
            'authorization' => 'Bearer ' . $token,
            'content-type' => 'application/json',
        ]);
    }


    // public function linkZoom($id, $email)
    // {


    //     $user = User::findOrFail($id);

    //     if ($user->zoom_id == "") {

    //         $body = [
    //             'action' => "create",
    //             'user_info' => [
    //                 'email' => $email,
    //                 'first_name' => $user->name,
    //                 'type' => 1
    //             ]
    //         ];


    //         $res = $this->zoomPost('users', $body);

    //         $res = json_decode($res->body(), true);

    //         if (isset($res['id'])) {
    //             $user->zoom_id = $res['id'];
    //             $user->zoom_email = $email;
    //             $user->save();

    //             return $data = [
    //                 'message' => 'You have been associated with Ipersona Zoom portol.However, check your email inbox to accept invitation.'
    //             ];
    //         }

    //         return $data = ['message' => 'This email is already exist plz use another'];
    //     }

    //     return $data = [
    //         'message' => 'You have already linked with Zoom.'
    //     ];
    // }

    public function zoomGet(string $path, array $body = [])
    {
        $request = $this->zoomRequest();
        return $request->get(config('zoom.base_url') . $path, $body);
    }

    /**
     * Display a zoomPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function zoomPost(string $path, array $body = [])
    {
        $request = $this->zoomRequest();
        return $request->post(config('zoom.base_url') . $path, $body);
    }
}
