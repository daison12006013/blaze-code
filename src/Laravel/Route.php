<?php

namespace BlazeCode\Laravel;

use BlazeCode\Contract\RouterInterface;
use Illuminate\Support\Facades\Route as FacadeRoute;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
class Route implements RouterInterface
{
    /**
     * {@inherit}
     */
    public function register(string $directory, array $maps)
    {
        foreach ($maps as $map) {
            FacadeRoute::group(
                [
                    'namespace' => $map['namespace'],
                    'prefix' => $map['prefix'],
                    'middleware' => $map['middleware'],
                ],
                function () use ($directory, $map) {
                    $setting = [
                        'prefix' => $map['with_suffix'] ? $map['route'] : '',
                    ];

                    FacadeRoute::group($setting, function () use ($directory, $map) {
                        $file = sprintf('%s/%s/%s.php',
                            $directory,
                            str_replace('.0', '', $map['prefix']), # we need to strip out ".0" to any versions to e.g(1.0 = 1)
                            $map['route']
                        );

                        require $file;
                    });
                }
            );
        }
    }
}
