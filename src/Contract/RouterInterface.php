<?php

namespace BlazeCode\Contract;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
interface RouterInterface
{
    /**
     * Register the general route maps to respected framework adapter.
     *
     * @param string $directory
     * @param array $maps
     * @return void
     */
    public function register(string $directory, array $maps);
}
