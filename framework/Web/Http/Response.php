<?php

namespace Majframe\Web\Http;

final class Response
{
    const JSON = 'json';
    const XML = 'xml';
    private int $responseCode = 200;

    public function __construct()
    {

    }

    public function setHeader()
    {

    }

    public function setResponseCode(int $code)
    {
        $this->responseCode = $code;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }
}