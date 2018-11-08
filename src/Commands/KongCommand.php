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

use Publisher\Service\Kong;
use Publisher\Config\KongConfig;
use Swoft\App;
use Swoft\Console\Bean\Annotation\Command;
use Swoft\Console\Input\Input;
use Swoft\Console\Output\Output;
use Swoftx\Creater\Common\Writer;

/**
 * Kong网关 脚本
 * @Command(coroutine=false)
 */
class KongCommand
{
    /**
     * 打印某网关所有Target
     * @Usage {command} services
     * @Example {command} upstream=SwoftUpstream
     * @return int
     */
    public function targets(Input $input, Output $output): int
    {
        $upstreamName = $input->getArg('upstream');
        if (is_null($upstreamName)) {
            $output->colored("upstream is required!", 'error');
            exit;
        }

        $kong = bean(Kong::class);
        $res = $kong->targets($upstreamName);

        $data = $res['data'] ?? [];
        if (empty($data)) {
            $output->colored("Targets is empty!", 'error');
            exit;
        }

        foreach ($data as $item) {
            $id = $item['id'];
            $target = $item['target'];
            $weight = $item['weight'];

            $output->writeln($id . "\t" . $target . "\t" . $weight);
        }

        return 0;
    }

    /**
     * 上线Target
     * @Usage {command} services
     * @Example {command} upstream=SwoftUpstream target=127.0.0.1:8080 weight=100
     * @return int
     */
    public function targetUp(Input $input, Output $output)
    {
        $upstreamName = $input->getArg('upstream');
        $target = $input->getArg('target');
        $weight = $input->getArg('weight');

        if (is_null($upstreamName) || is_null($target) || is_null($weight)) {
            $output->colored("params invalid!", 'error');
            exit;
        }

        $kong = bean(Kong::class);
        $res = $kong->targetUp($upstreamName, $target, $weight);

        if (!isset($res['id'])) {
            $output->colored("target up failed!", 'error');
            exit;
        }

        $output->colored('target up success! id= ' . $res['id']);
    }

    /**
     * 下线Target
     * @Usage {command} services
     * @Example {command} upstream=SwoftUpstream target=xxxxx
     * @return int
     */
    public function targetDown(Input $input, Output $output)
    {
        $upstreamName = $input->getArg('upstream');
        $target = $input->getArg('target');

        if (is_null($upstreamName) || is_null($target)) {
            $output->colored("params invalid!", 'error');
            exit;
        }

        $kong = bean(Kong::class);
        $res = $kong->targetDown($upstreamName, $target);

        if (!$res) {
            $output->colored("target down failed!", 'error');
        }

        $output->colored('target down success!');
    }
}
