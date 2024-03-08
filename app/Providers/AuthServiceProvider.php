<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Http;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('isRole', function ($roles = [], $code = '') {
            if (empty($roles)) {
                return false;
            }
            $session = new Session();
            $role_name = $session->get('role_name');
            $token = $session->get('access_token');
            $id = $session->get('id');
            if (in_array('assistant', $roles) && $code == '') {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer " . $token,
                    'Content-Type' => "application/json"
                ])->post(
                    env("URL_API", "http://example.com") . '/api/v1/user/check/role',
                    [
                        'user_id' => $id,
                    ]
                );
                if ($response['data']) {
                    return ($response['data']);
                }
            } elseif (in_array('assistant', $roles) && $code) {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer " . $token,
                    'Content-Type' => "application/json"
                ])->post(
                    env("URL_API", "http://example.com") . '/api/v1/assistant/check',
                    [
                        'user_id' => $id,
                        'course_code' => $code
                    ]
                );
                if ($response['data']) {
                    return ($response['data']);
                }
            }


            return in_array($role_name, $roles);
        });
        Blade::if('isSubmit', function ($guid) {
            $session = new Session();
            $token = $session->get('access_token');
            $id = $session->get('id');
            $response = Http::withHeaders([
                'Authorization' => "Bearer " . $token,
                'Content-Type' => "application/json"
            ])->post(
                env("URL_API", "http://example.com") . '/api/v1/topic/check/submit',
                [
                    'topic_guid' => $guid,
                    'user_id' => $id,
                ]
            );

            return ($response['data']);
        });
    }
}
