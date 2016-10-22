<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class SenatorRoomSession extends AbstractEndpoint
{
	public function number($number)
	{
		return $this->setParam('number', $number);
	}

	public function getSessions()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'sesiones.php?',
					'legislatura='.array_get($params, 'number'),
				]);
			});
	}
}
