<?php namespace RachidLaasri\GooglePlayAPI\Facades;

use Illuminate\Support\Facades\Facade;

class GooglePlay extends Facade {
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GooglePlay';
    }
}