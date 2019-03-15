<?php

$spBaseUrl = '';
$feBaseUrl = '';

$settingsInfo = array (
    'sp' => array (
        'entityId' => $spBaseUrl.'/saml/master/metadata.php',
        'assertionConsumerService' => array (
            'url' => $spBaseUrl.'/saml/master/index.php?acs',
        ),
        'singleLogoutService' => array (
            'url' => $spBaseUrl.'/saml/master/index.php?sls',
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
