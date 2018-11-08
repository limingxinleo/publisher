<?php


namespace Publisher\Config;

use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Value;

/**
 * @Bean
 */
class KongConfig
{
    /**
     * @Value(name="${config.kong.uri}")
     */
    public $uri;

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }
}