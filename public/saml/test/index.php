<?php

require_once dirname(__DIR__).'/_toolkit_loader.php';
require_once 'settings.php';

$auth = new OneLogin_Saml2_Auth($settingsInfo);

if (isset($_GET['slo'])) {
    header('Location: ' . $feBaseUrl);
} else if (isset($_GET['acs'])) {
    if (is_null($personalIdentityNumber = $auth->personalIdentityNumber())) {
        die('ERROR 404: personalIdentityNumber');
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $spBaseUrl . '/v1/auth/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'personal_identity_number=' . $personalIdentityNumber . '&password=secret');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $serverOutput = curl_exec($ch);

    curl_close ($ch);

    list($header, $payload, $signature) = explode ('.', json_decode($serverOutput)->token);

    if (json_decode(base64_decode($payload))->role === 'AU') {
        header('Location: uniwebview://onResponse?token=' . json_decode($serverOutput)->token);
    } else {
        header('Location: ' . $feBaseUrl . '?token=' . json_decode($serverOutput)->token);
    }
}
