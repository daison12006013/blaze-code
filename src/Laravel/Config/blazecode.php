<?php

return [
    /**
     * Error Levels by Default
     *
     * 2 = throws the exception
     * 1 = returns an array, that has the exception object and trace
     * 0 = returns an array, only provides the exception message
     * false = like "0" , but replaces the exception message to use 'default_error_message'
     */
    'error_level' => env('BLAZECODE_ERROR_LEVEL', 0),

    /**
     * Provide the default message when using 'error_level' as false
     */
    'default_error_message' => 'Something went wrong, please try again.',
];
