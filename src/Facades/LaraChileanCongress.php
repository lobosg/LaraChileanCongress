<?php

namespace Unforgivencl\LaraChileanCongress\Facades;

use Illuminate\Support\Facades\Facade;

class LaraChileanCongress extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Unforgivencl\LaraChileanCongress\CongressApi\ApiRequest';
    }
}
