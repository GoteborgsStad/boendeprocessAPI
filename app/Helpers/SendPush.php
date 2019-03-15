<?php

/*
 *  Send Push
 */
if (!function_exists('sendPush')) {

    function sendPush($title, $subtitle, $text, $scheduledTime, $ticker, $users, $services = [])
    {
        require_once('Firebase.php');
        require_once('Push.php');

        $iosPushUrl       = env('IOS_PUSH_URL');
        $iosCertFolder    = env('IOS_CERT_FOLDER');

        foreach ($users as $user) {
            foreach ($services as $service) {
                // @codingStandardsIgnoreStart
                switch ($service) {
                    case 'Sambuh':
                        $cn = env('SAMBUH_PUSH_CERT_NAME');
                        $cp = env('SAMBUH_PUSH_CERT_PASSWORD');
                        $api = env('SAMBUH_PUSH_CERT_API');
                    break;
                    default:
                        $cn     = 'None';
                        $cp     = 'None';
                        break;
                }
                // @codingStandardsIgnoreEnd

                $devices    = $user->devices()->where('app', $service)->get();
                $responses  = [];
                $payloads   = [
                    'android'   => [],
                    'ios'       => []
                ];

                foreach ($devices as $device) {
                    $deviceToken = $device->token;

                    switch ($device->type) {
                        case 'android':
                            array_push($payloads['android'], [
                                'pdt'                  => $deviceToken,
                                'api'                  => $api,
                                'subtitle'             => $subtitle,
                                'title'                => $title,
                                'text'                 => $text,
                                'ticker'               => 'ticker-test',
                                'app'                  => 'sambuh',
                                'notification_payload' => ($service === 'Sambuh') ? 1 : 0
                            ]);
                            break;
                        case 'ios':
                            array_push($payloads['ios'], [
                                'pdt'   =>  $deviceToken,
                                'cn'    =>  $cn,
                                'cp'    =>  $cp,
                                'title' =>  $title,
                                'text'  =>  $text,
                                'badge' =>  $ticker,
                                'app'   => 'sambuh'
                            ]);
                            break;
                    }
                }

                // Send push to android devices
                if (!empty($payloads['android'])) {
                    foreach ($payloads['android'] as $key => $payload) {
                        $notificationPayload = $payload['notification_payload'];

                        // @codingStandardsIgnoreStart
                        if (empty($payload['app']) || empty($payload['pdt']) || empty($payload['api']) || empty($title) || empty($text)) {
                            echo 'missing_input';
                        }
                        // @codingStandardsIgnoreEnd

                        if (empty($subtitle)) {
                            $subtitle = $text;
                        }

                        if (empty($ticker)) {
                            $ticker = $title;
                        }

                        if (!empty($image)) {
                            $push = new Push($title, $text, $image);
                        } else {
                            $push = new Push($title, $text, null);
                        }

                        $mPushNotification = $push->getPush();

                        $firebase = new Firebase();

                        // @codingStandardsIgnoreStart
                        $res = $firebase->send($payload['pdt'], $mPushNotification, $payload['api'], $notificationPayload);
                        // @codingStandardsIgnoreEnd

                        $resObj = json_decode($res);

                        if (!$resObj->success) {
                            if ($resObj->results[0]->error === 'NotRegistered') {
                                \App\Device::where('token', $payload['pdt'])->firstOrFail()->delete();
                            }
                        }
                    }
                }

                // Sending push to iOS device
                if (!empty($payloads['ios'])) {
                    $iosPayload = json_encode($payloads['ios']);

                    foreach ($payloads['ios'] as $key => $payload) {
                        $pdt = $payload['pdt'];

                        // @codingStandardsIgnoreStart
                        if (empty($payload['app']) || empty($pdt) || empty($cn) || empty($cp) || empty($title) || empty($text)) {
                            http_response_code(400);
                            die('missing_input');
                        }
                        // @codingStandardsIgnoreEnd

                        $certFilename       = trim(preg_replace('/[^0-9A-Za-z_-]/', '', $cn)) . '.pem';
                        $fullpath           = env('IOS_CERT_FOLDER') . $certFilename;
                        $APS = ['badge' => $payload['badge']];

                        if ($text) {
                            $APS['alert'] = ['title' => $title, 'body' => $text];
                            $APS['sound'] = 'default';
                        }

                        $ctx = stream_context_create();

                        stream_context_set_option($ctx, 'ssl', 'local_cert', $fullpath);
                        stream_context_set_option($ctx, 'ssl', 'passphrase', $cp);

                        $err        = null;
                        $errMessage = '';

                        $fp = stream_socket_client($iosPushUrl, $err, $errMessage, 60, STREAM_CLIENT_CONNECT, $ctx);

                        if (!$fp) {
                            return false;
                        }

                        $payload = json_encode(['aps' => $APS]);

                        // Build the binary notification
                        // @codingStandardsIgnoreStart
                        $msg = chr(0) . pack('n', 32) . pack('H*', $pdt) . pack('n', strlen($payload)) . $payload;
                        // @codingStandardsIgnoreEnd

                        $result = fwrite($fp, $msg, strlen($msg));

                        $success = true;

                        if (!$result) {
                            $success = false;
                        }

                        fclose($fp);

                        if ($success === true) {
                            echo true;
                        } else {
                            echo false;
                        }
                    }
                }
            }
        }
    }
}
