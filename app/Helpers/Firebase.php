<?php

// @codingStandardsIgnoreStart
class Firebase
{
    public function send($to, $message, $api, $notificationPayload)
    {
        $fields = [
            'to' => $to,
            'data' => $message
        ];

        return $this->sendPushNotification($fields, $api, $notificationPayload);
    }

    private function sendPushNotification($fields, $api, $notificationPayload)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = [
            'Authorization: key=' . $api,
            'Content-Type: application/json',
        ];

        if ($notificationPayload == 1) {
            $fields['notification'] = [
                'title' => $fields['data']['data']['title'],
                'text'  => $fields['data']['data']['message'],
                'icon'  => 'default',
                'sound' => 'default',
            ];

            $data                       = $fields['data']['data'];
            $fields['data']             = $fields['data']['data'];
            $fields['data']['data']     = $data;
            $fields['data']['subtitle'] = $fields['data']['message'];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        if ($result === false) {
            return [
                'success' => 0,
                'CURL Error' => curl_error($ch),
            ];
        }

        curl_close($ch);

        return $result;
    }
}
// @codingStandardsIgnoreEnd
