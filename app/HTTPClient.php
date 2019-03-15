<?php

namespace App;

class HTTPClient
{
    private $host           = 'host';
    private $contentType    = 'application/json; charset=utf-8';

    const STR_BOM           = "\xEF\xBB\xBF";

    public function __construct(
        $host,
        $authorization = null,
        $contentType = 'application/json; charset=utf-8',
        $accept = 'application/json'
    ) {
        $this->host             = $host;
        $this->authorization    = $authorization;
        $this->contentType      = $contentType;
        $this->accept           = $accept;
    }

    public function call($method, $uri, $payload = null, $extraHeaders = [])
    {
        if (stristr($this->contentType, 'json')) {
            $data = json_encode($payload);
        }

        if (stristr($this->contentType, 'x-www-form-urlencoded')) {
            $data = http_build_query($payload);
        }

        $headers = [
            'Accept'            => $this->accept,
            'Host'              => parse_url($this->host, PHP_URL_HOST),
            'Content-Type'      => $this->contentType,
            'Content-Length'    => strlen($data),
            'User-Agent'        => 'activibe http client',
            'Authorization'     => $this->authorization,
        ];

        $headers = array_merge($headers, $extraHeaders);

        $headerString = null;

        foreach ($headers as $key => $value) {
            $headerString .= $key . ': '.$value ."\r\n";
        }
        $opts = [
            'http' => [
                'method'    => $method,
                'header'    => $headerString,
                'content'   => is_string($data) ? $data : null,
                'timeout'   => 60
            ],
            'ssl' => [
                'verify_peer'   => false
                //'cafile'        => __DIR__ . '/cacert.pem',
                //'verify_depth'  => 5,
                //'CN_match'      => 'secure.example.com'
            ],
        ];

        try {
            $handle = @fopen($this->host . $uri, 'r', false, stream_context_create($opts));
            $content = '';
            $meta = @stream_get_meta_data($handle);

            if ($handle === false) {
                throw new \Exception('Could not fetch data from URI.');
            }
            while (!feof($handle)) {
                $content .= fread($handle, 8192);
            }

            if (stristr($content, \App\HTTPClient::STR_BOM) !== false) {
                $content = str_replace(\App\HTTPClient::STR_BOM, '', $content);
            }

            $result = $content;
            if ($result === null) {
                throw new \Exception('['.json_last_error() . '] ' . json_last_error_msg() . '.');
            }
        } catch (\Exception $e) {
            $result = false;
        }
        return $result;
    }
}
