<?php

namespace App\Action\Example;

use Predis\ClientInterface;

class RedisClientService
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function getClient()
    {
        return $this->client;
    }
    //$value = $this->cache->get('my_cache_key');
}