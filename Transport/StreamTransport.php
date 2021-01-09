<?php

namespace Jules\PhpXmlRpc;

use Jules\PhpXmlRpc\Exceptions\TransportException;

class StreamTransport implements Transport
{
    /**
     * 
     * @var array
     */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function send(string $url, string $request): Response
    {
        $options = array_merge(
            $this->options,
            array(
                'http' => array(
                    'method' => "POST",
                    "header" => "Content-Type: text/xml",
                    "content" => $request
                )
            )
        );

        $context = stream_context_create($options);

        $result = @file_get_contents($url, false, $context);

        if (!$result) {
            throw new TransportException("Could not access " . $url);
        }

        return new Response($result);
    }
}