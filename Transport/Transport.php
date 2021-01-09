<?php

namespace Julesdevops\PhpXmlRpc;

use Julesdevops\PhpXmlRpc\Response;

interface Transport
{
    public function send(string $url, string $request): Response;
}