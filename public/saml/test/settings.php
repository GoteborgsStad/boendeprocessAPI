<?php

$spBaseUrl = '';
$feBaseUrl = '';

$settingsInfo = array (
    'sp' => array (
        'entityId' => $spBaseUrl.'/saml/test/metadata.php',
        'assertionConsumerService' => array (
            'url' => $spBaseUrl.'/saml/test/index.php?acs',
        ),
        'singleLogoutService' => array (
            'url' => $spBaseUrl.'/saml/test/index.php?sls',
        ),
        'NameIDFormat' => '',
    ),
    'idp' => array (
        'entityId' => '',
        'singleSignOnService' => array (
            'url' => '',
        ),
        'singleLogoutService' => array (
            'url' => '',
        ),
        'x509cert' => '',
    ),
);
