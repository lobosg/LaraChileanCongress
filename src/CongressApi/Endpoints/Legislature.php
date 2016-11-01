<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class Legislature extends AbstractEndpoint
{
    public function getLegislatures()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'getLegislaturas',
                ]);
            });
    }

    public function getActualLegislature()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'getLegislaturaActual',
                ]);
            });
    }
}
