<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'ticker',
        'redirect_to',
        'image_url',
        'audio_url',
    ];

    protected $hidden   = [
        'pivot',
    ];

    const STATUS_OK                     = 'ok';
    const STATUS_UNKNOWN_DEVICE_TYPE    = 'unknown_device_type';
    const STATUS_MISSING_PARAMETERS     = 'missing_parameters';
    const STATUS_ERROR                  = 'error';
    const STATUS_INVALID_REGISTRATION   = 'invalid_registration';

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function getImageUrlAttribute($value)
    {
        return \App\File::path($value, \App\File::TYPE_IMAGE);
    }

    public function sendToMany(\Illuminate\Database\Eloquent\Collection $users, $deviceApp = null)
    {
        $http = new HTTPClient(
            env('INTEGRATION_API_URL'),
            null,
            'application/x-www-form-urlencoded'
        );

        $data       = [];
        $responses  = [];

        $payloads = [
            'android'   => [],
            'ios'       => [],
        ];

        $results = [
            'calls'     => 0,
            'successes' => 0,
            'errors'    => [],
        ];

        foreach ($users as $user) {
            $data[] = $this->send($user, $deviceApp, true);
        }

        foreach ($data as $pl) {
            $payloads['android'] = array_merge($payloads['android'], $pl['android']);
            $payloads['ios'] = array_merge($payloads['ios'], $pl['ios']);
        }

        if (!empty($payloads['android'])) {
            $androidPayload = json_encode($payloads['android']);
            $responses[] = $http->call(
                'POST',
                '',
                [
                    '_params' => $androidPayload,
                ],
                [
                    'q-url' => 'http://integration1.iusinnovation.com/mobile_push/android.php',
                    'q-name' => 'sambuh',
                ]
            );
        }

        if (!empty($payloads['ios'])) {
            $iosPayload = json_encode($payloads['ios']);
            $responses[] = $http->call(
                'POST',
                '',
                [
                    '_params' => $iosPayload,
                ],
                [
                    'q-url' => 'http://integration1.iusinnovation.com/mobile_push/ios.php',
                    'q-name' => 'sambuh',
                ]
            );
        }

        return $responses;
    }

    public function send(User $user, $deviceApps = null, $onlyPayload = false)
    {
        $results = [];

        if (!is_array($deviceApps)) {
            $deviceApps = [$deviceApps];
        }

        foreach ($deviceApps as $deviceApp) {
            $notification = $this->create([
                'scheduledTime' => true,
                'title'         => $this->title,
                'body'          => $this->body,
                'ticker'        => $this->ticker,
                'redirect_to'   => $this->redirect_to,
                'image_url'     => $this->image_url,
                'audio_url'     => $this->audio_url,
            ]);

            $http = new HTTPClient(
                env('INTEGRATION_API_URL'),
                null,
                'application/x-www-form-urlencoded'
            );

            switch ($deviceApp) {
                case 'Sambuh':
                    $cn = 'sambuh_cert';
                    $cp = 'Qwerty77';
                    $api = 'AAAARWNrD34:APA91bHbfvBKH0Q2M9iRpM4927Q0z7mmSL0qlRbTRlIfx0j7aEQfPAgYX2SjGO_fyJJ45S8O_KbUUee2-kENuL2QViFhrkgUFqTrMzrLIMWOwtz_dTz1PrpQzPwDToQnLIGZoJ-Qstf3';

                    break;
                default:
                    $cn = 'None';
                    $cp = 'None';

                    break;
            }

            $devices = $user->devices()->where('app', $deviceApp)->get();

            $responses = [];

            $payloads = [
                'android' => [],
                'ios' => [],
            ];

            foreach ($devices as $device) {
                switch ($device->type) {
                    case 'android':
                        $payloads['android'][] = [
                            'pdt'                  => $device->token,
                            'api'                  => $api,
                            'subtitle'             => $notification->subtitle,
                            'title'                => $notification->title,
                            'text'                 => $notification->body,
                            'ticker'               => 'ticker-test',
                            'app'                  => 'sambuh',
                            'notification_payload' => ($deviceApp === 'Sambuh') ? 1 : 0
                        ];

                        break;
                    case 'ios':
                        $payloads['ios'][] = [
                            'pdt'   => $device->token,
                            'cn'    => $cn,
                            'cp'    => $cp,
                            'title' => $notification->title,
                            'text'  => $notification->body,
                            'badge' => $notification->ticker,
                            'app'   => 'sambuh'
                        ];

                        break;
                    case 'other':
                        $payload = [
                            'test' => 'test'
                        ];

                        $responses[] = \App\Notification::STATUS_UNKNOWN_DEVICE_TYPE;

                        break;
                }
            }

            if ($onlyPayload) {
                return $payloads;
            }

            if (!empty($payloads['android'])) {
                $androidPayload = json_encode($payloads['android']);

                $responses[] = $http->call(
                    'POST',
                    '',
                    [
                        '_params' => $androidPayload,
                    ],
                    [
                        'q-url' => 'http://integration1.iusinnovation.com/mobile_push/android.php',
                        'q-name' => 'sambuh',
                    ]
                );
            }

            if (!empty($payloads['ios'])) {
                $iosPayload = json_encode($payloads['ios']);

                $responses[] = $http->call(
                    'POST',
                    '',
                    [
                        '_params' => $iosPayload,
                    ],
                    [
                        'q-url' => 'http://integration1.iusinnovation.com/mobile_push/ios.php',
                        'q-name' => 'sambuh',
                    ]
                );
            }

            $result = ['calls' => 0, 'successes' => 0, 'errors' => []];
            foreach ($responses as $response) {
                $result['calls']++;
                $response = strip_tags($response);

                if ($response == \App\Notification::STATUS_OK) {
                    $result['successes']++;
                } else {
                    $result['errors'][] = $response . ': ' . $device->token;
                }
                // $device_notification = $notification->devices()->attach($device->id);
            }

            $results[] = $result;
        }

        return $results;
    }
}
