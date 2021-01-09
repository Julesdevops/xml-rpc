<?php

namespace Julesdevops\PhpXmlRpc;

use Julesdevops\PhpXmlRpc\Exceptions\ConfigurationException;
use Julesdevops\PhpXmlRpc\Response;
use Julesdevops\PhpXmlRpc\Transport\StreamTransport;

class Client
{
    /**
     * 
     * @var string
     */
    private $url;

    /**
     * 
     * @var array
     */
    private $options;

    /**
     * 
     * @var Transport
     */
    private $transport;

    /**
     * 
     * @var array
     */
    private $outputOptions = array(
        "output_type" => "xml",
        "verbosity" => "pretty",
        "escaping" => array("markup"),
        "version" => "xmlrpc",
        "encoding" => "utf-8"
    );

    public function __construct(string $url, array $options)
    {
        if (!function_exists('xmlrpc_encode_request')) {
            throw new ConfigurationException("PHP XML-RPC extension is not available.");
        }

        $this->$url = $url;
        $this->$options = $options;
        $this->$transport = new StreamTransport();
    }

    public function rpcCall(string $remoteMethod, array $args): Response
    {
        $request = xmlrpc_encode_request($remoteMethod, $args, $this->outputOptions);

        $response = $this->transport->send($this->url, $request);

        $response->checkForFault();

        return $response;
    }
}