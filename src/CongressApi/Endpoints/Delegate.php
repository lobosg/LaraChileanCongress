<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

class Delegate extends AbstractEndpoint
{
	public function number($number)
	{
		return $this->setParam('number', $number);
	}

	public function getDelegates()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'getDiputados_Vigentes',
				]);
			});
	}

	public function getLegislativePeriods()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'getPeriodosLegislativos',
				]);
			});
	}

	public function getDelegatesByLegislativePeriod()
	{
		return $this->setHttpMethod('GET')
			->setUriGenerator(function ($params) {
				return implode('', [
					'getDiputados_Periodo?',
					'prmPeriodoID='.array_get($params, 'number'),
				]);
			});
	}
}
