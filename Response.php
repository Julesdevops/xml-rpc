<?php

namespace Julesdevops\PhpXmlRpc;

use Julesdevops\PhpXmlRpc\Exceptions\RemoteException;

class Response
{
    /**
     * 
     * @var string
     */
    private $xmlResult;

    /**
     * 
     * @var mixed
     */
    private $decodedResult;

    public function __construct(string $xmlResult)
    {
        $this->xmlResult = $xmlResult;
        $this->decodedResult = xmlrpc_decode($xmlResult, "utf-8");
    }

    public function checkForFault(): void
    {
        if ($this->isFault()) {
            throw new RemoteException(
                $this->decodedResult['faultString'], 
                $this->decodedResult['faultCode']
            );
        }
    }

    public function isFault(): bool
    {
        if (is_array($this->decodedResult)) {
            return xmlrpc_is_fault($this->decodedResult);
        }
    
        return false;
    }

    public function getDecodedResult(): mixed
    {
        return $this->decodedResult;
    }
}