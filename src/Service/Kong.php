<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Publisher\Service;

use Publisher\Config\KongConfig;
use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;

/**
 * Class Kong
 * @Bean
 */
class Kong extends Service
{
    /**
     * @Inject
     * @var KongConfig
     */
    public $config;

    public function services()
    {
        return $this->get('/services');
    }

    public function service($id)
    {
        return $this->get("/services/$id");
    }

    public function upstreams($upstreamName)
    {
        return $this->get("/upstreams/{$upstreamName}");
    }

    public function targets($upstreamName)
    {
        return $this->get("/upstreams/{$upstreamName}/targets");
    }

    public function targetUp($upstreamName, $target, $weight)
    {
        $services = $this->json("/upstreams/{$upstreamName}/targets", [
            'target' => $target,
            'weight' => $weight
        ]);

        return $services;
    }

    public function targetDown($upstreamName, $target)
    {
        $res = $this->delete("/upstreams/{$upstreamName}/targets/$target");

        $res->getStatusCode();
        return $res->getStatusCode() === 200 || $res->getStatusCode() === 204;
    }
}
