<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class Votation extends AbstractEndpoint
{
    public function number($number)
    {
        return $this->setParam('number', $number);
    }

    public function getSenatorsVotation()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'votaciones.php?',
                    'boletin='.array_get($params, 'number'),
                ]);
            });
    }

    public function getDelegatesVotation()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'getVotaciones_Boletin?prmBoletin='.array_get($params, 'number'),
                ]);
            });
    }

    public function getDetailedDelegatesVotation()
    {
        return $this->setHttpMethod('GET')
            ->setUriGenerator(function ($params) {
                return implode('', [
                    'getVotacion_Detalle?prmVotacionID='.array_get($params, 'number'),
                ]);
            });
    }
}
