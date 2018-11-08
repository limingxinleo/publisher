<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

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
