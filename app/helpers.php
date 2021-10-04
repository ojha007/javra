<?php

use Illuminate\Support\Facades\Log;


if (!function_exists('logException')) {
    function logException(Exception $exception)
    {
        Log::error(
            $exception->getMessage()
            . '<==================================>'
            . $exception->getTraceAsString());
    }
}

