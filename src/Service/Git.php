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

use Swoft\Bean\Annotation\Bean;

/**
 * @Bean
 */
class Git
{
    public function tags($git)
    {
        $sh = 'git ls-remote -t ' . $git;

        $output = [];
        exec($sh, $output);

        $result = [];
        foreach ($output as $item) {
            if (strpos($item, '^{}') === false) {
                preg_match('/refs\/tags\/(.*)$/', $item, $v);
                if (isset($v[1])) {
                    $result[] = $v[1];
                }
            }
        }

        usort($result, function ($a, $b) {
            return version_compare($a, $b, '<');
        });

        return $result;
    }
}
