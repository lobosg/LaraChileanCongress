<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class Senator extends AbstractEndpoint
{
    public function getSenators()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'senadores_vigentes.php',
                ]);
            });
    }
}
