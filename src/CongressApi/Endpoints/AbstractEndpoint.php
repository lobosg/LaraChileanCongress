<?php

namespace Unforgivencl\LaraChileanCongress\CongressApi\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Collection;
use GuzzleHttp\Psr7\Request;

abstract class AbstractEndpoint
{
	protected $client;
	protected $params = [];
	protected $uriGenerator;
	protected $httpMethod = 'GET';
	protected $webServiceMode;

	protected $errorCodes = [
		500 => \Unforgivencl\LaraChileanCongress\CongressApi\Exceptions\InternalServerErrorException::class,
	];

	public function __construct(ClientInterface $client, $args = [])
	{
		$this->client = $client;
		$this->webServiceMode = 1;

		return $this;
	}

	/**
	 * Set values for parameter to generate endpoint.
	 *
	 * @param string $key   Name of params
	 * @param mixed  $value Its value
	 *
	 * @return AbstractEndpoint
	 */
	public function setParam($key, $value)
	{
		$this->params[$key] = $value;

		return $this;
	}

	/**
	 * Define which HTTP method should be sent, as well as how to generate
	 * URI of resource.
	 *
	 * @param string   $method       Either GET POST PUT DELETE
	 * @param callable $uriGenerator
	 *
	 * @return AbstractRequest
	 */
	public function setHttpMethod($method, callable $uriGenerator = null)
	{
		$this->httpMethod = $method;

		if ($uriGenerator !== null) {
			$this->setUriGenerator($uriGenerator);
		}

		return $this;
	}

	public function setUriGenerator(callable $uriGenerator)
	{
		$this->uriGenerator = $uriGenerator;

		return $this;
	}

	/**
	 * Subclasses will define how URI of an endpoint is generated.
	 *
	 * @return string
	 */
	public function generateResourceUri()
	{
		if ($this->uriGenerator === null) {
			throw new \ErrorException('Dont know how to generate URL. Maybe resources were missing?');
		}

		return call_user_func($this->uriGenerator, $this->params);
	}

	public function getUrl(array $queryString = [])
	{
		if ($this->webServiceMode == 1) {
			return 'http://www.'
				.'senado.cl/wspublico/'
				.$this->generateResourceUri()
				.http_build_query($queryString);
		} else {
			return 'http://opendata.congreso.cl/'
			.'wscamaradiputados.asmx/'
			.$this->generateResourceUri()
			.http_build_query($queryString);
		}
	}

	public function setSenators()
	{
		$this->webServiceMode = 1;

		return $this;
	}

	public function setDelegates()
	{
		$this->webServiceMode = 2;

		return $this;
	}

	/**
	 * Send HTTP request to Congress API.
	 *
	 * @param array $queryParameters Optional query string data
	 *
	 * @return array                         If request a single entry
	 * @return Illuminate\Support\Collection If request a collection of resources
	 */
	public function fetch(array $queryParameters = [])
	{
		$url = $this->getUrl($queryParameters);

		try {
			$result = $this->client->request($this->httpMethod, $url);

			// Process response data

			$data = $result->getBody();

			$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

			$json = json_encode($xml);

			$json_response = json_decode($json, true);

			if (isset($json_response[0]) && is_array($json_response[0])) {
				return new Collection($json_response);
			}

			return $json_response;
		} catch (ServerException $ex) {
			$response = $ex->getResponse();

			return $this->handleError($response);
		}
	}

	/**
	 * Children classes have to define how to handle with error.
	 * Throwing exceptions for example.
	 *
	 * @param  $response Response returned from WS
	 */
	public function handleError($response)
	{
		$code = $response->getStatusCode();
		if (!isset($this->errorCodes[$code])) {
			throw new \ErrorException('Unsupported error for status code: '.$code);
		}
		$ex = new $this->errorCodes[$code]();
		$ex->response = $response;
		throw $ex;
	}
}
