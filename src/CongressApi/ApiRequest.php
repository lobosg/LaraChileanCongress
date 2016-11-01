<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi;

use GuzzleHttp\ClientInterface;
use ErrorException;

class ApiRequest
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function __call($name, $args)
    {
        $map = [
            'law' => Endpoints\Law::class,
            'lawproject' => Endpoints\LawProject::class,
            'votation' => Endpoints\Votation::class,
            'senator' => Endpoints\Senator::class,
            'delegate' => Endpoints\Delegate::class,
            'session' => Endpoints\SenatorRoomSession::class,
            'legislature' => Endpoints\Legislature::class,
        ];

        if (!isset($map[$name])) {
            throw new ErrorException("Endpoint `$name` not found");
        }

        return new $map[$name]($this->client, $args);
    }
}
