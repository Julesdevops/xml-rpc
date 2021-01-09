<?php

namespace Jules\PhpXmlRpc;

use Jules\PhpXmlRpc\Response;

interface Transport
{
    public function send(string $url, string $request): Response;
}