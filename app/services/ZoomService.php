<?php

namespace App\Services;
use Firebase\JWT\JWT;

class ZoomService
{
    public function createSignature($meetingNumber, $role = 0)
    {
        $sdkKey = 'TmuEla_jRR2Hbq6fz4jA'; // SDK Key
        $sdkSecret = 'cOkzrVhdBWzWO3tgsXNUDOnZRZHaXpSh'; // SDK Secret

        // Waktu saat ini dalam detik (gunakan time() untuk mendapatkan timestamp detik)
        $currentTimestamp = time();

        $payload = [
            'sdkKey' => $sdkKey,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $currentTimestamp, // Issued at time langsung menggunakan waktu server
            'exp' => $currentTimestamp + 3600, // Expiry time dalam 1 jam dari waktu sekarang
            'appKey' => $sdkKey,
            'tokenExp' => $currentTimestamp + 3600, // Expiry token juga 1 jam dari sekarang
        ];

        return JWT::encode($payload, $sdkSecret, 'HS256');
    }
}
