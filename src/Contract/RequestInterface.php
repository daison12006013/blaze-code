<?php

namespace BlazeCode\Contract;

/**
 * @license MIT
 * @copyright 2017-2018
 * @author Daison Cariño <daison12006013@gmail.com>
 */
interface RequestInterface
{
    /**
     * When the request is succesful.
     *
     * @param array $transformed
     * @param array|mixed $raw
     * @return array
     */
    public function whenSuccess($transformed, $raw) : array;

    /**
     * When the request is failing.
     *
     * @return array
     */
    public function whenError($e) : array;
}
