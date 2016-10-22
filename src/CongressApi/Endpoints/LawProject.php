<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class LawProject extends AbstractEndpoint
{
	public function number($number)
	{
		return $this->setParam('number', $number);
	}

	public function date($date)
	{
		return $this->setParam('date', $date);
	}

	public function getLawProject()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'tramitacion.php?',
					'boletin='.array_get($params, 'number'),
				]);
			});
	}

	public function getLawsProjectWithMovement()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'tramitacion.php?',
					'fecha='.array_get($params, 'date'),
				]);
			});
	}
}
