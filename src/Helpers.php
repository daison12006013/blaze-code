<?php

namespace BlazeCode\Helpers;

if (! function_exists('repository')) {
    function repository($class, $params = [])
    {
        $instance = new $class;

        if (! method_exists($instance, 'handle')) {
            throw new Exception('Method [handle] not found.');
        }

        return function () use ($instance, $params) {
            return call_user_func_array([$instance, 'handle'], $params);
        };
    }
}
