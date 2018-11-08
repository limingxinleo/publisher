<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace Publisher\Commands;

use Publisher\Service\Git;
use Publisher\Service\Kong;
use Publisher\Config\KongConfig;
use Swoft\App;
use Swoft\Console\Bean\Annotation\Command;
use Swoft\Console\Input\Input;
use Swoft\Console\Output\Output;
use Swoftx\Creater\Common\Writer;

/**
 * Publisher 发布脚本
 * @Command(coroutine=false)
 */
class PublishCommand
{
    /**
     * 发布项目
     * @Usage {command} services
     * @Example {command} upstream=SwoftUpstream target=xxxxx
     * @return int
     */
    public function deploy(Input $input, Output $output)
    {
        $host = $input->getArg('host');
        if (is_null($host)) {
            $output->colored("host invalid!", 'error');
            exit;
        }

        $git = 'https://github.com/limingxinleo/swoft-project';

        $gitService = bean(Git::class);
        $res = $gitService->tags($git);

        $latest = $res[0];

        $sh = "ssh -t root@$host docker stop swoft-project";

        echo exec($sh);

        sleep(2);

        $sh = "ssh -t root@$host docker run --rm -d -p 8082:8080 --name swoft-project registry.cn-shanghai.aliyuncs.com/limingxinleo/swoft-project:" . $latest;

        echo exec($sh);
    }
}
