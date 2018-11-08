<?php


namespace Publisher\Service;


use Swoft\Helper\JsonHelper;
use Swoft\HttpClient\Client;

abstract class Service
{
    /** @var Client */
    protected $client;

    protected function getClient()
    {
        if (isset($this->client) && $this->client instanceof Client) {
            return $this->client;
        }

        return $this->client = new Client([
            'base_uri' => $this->config->getUri()
        ]);
    }

    protected function get($uri, $data = [])
    {
        $client = $this->getClient();
        if ($data) {
            $uri .= '?' . http_build_query($data);
        }
        $res = $client->get($uri)->getResult();

        return JsonHelper::decode($res, true);
    }

    protected function json($uri, $data = [])
    {
        $client = $this->getClient();
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8'
        ];
        $res = $client->post($uri, [
            'headers' => $headers,
            'body' => JsonHelper::encode($data, JSON_UNESCAPED_UNICODE)
        ])->getResult();

        return JsonHelper::decode($res, true);
    }

    protected function delete($uri)
    {
        $client = $this->getClient();

        return $client->delete($uri)->getResponse();
    }
}