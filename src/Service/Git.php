<?php


namespace Publisher\Service;

use Swoft\Bean\Annotation\Bean;
use Swoft\Helper\ArrayHelper;

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