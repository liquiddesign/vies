<?php

namespace Vies;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiConnection
{
	private ?Client $client = null;

	public function __construct(
		private readonly string $baseUrl,
		private readonly string $login,
		private readonly string $password
	) {
	}

	/**
	 * @param string $method
	 * @param string $endpoint
	 * @param array<string, mixed> $params
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function request(string $method, string $endpoint, array $params = []): ResponseInterface
	{
		if ($this->client === null) {
			$this->client = new Client([
				'auth' => [$this->login, $this->password],
				'http_errors' => false,
				'base_uri' => $this->baseUrl,
			]);
		}

		return $this->client->request($method, $endpoint, [
			'json' => $params,
		]);
	}
}
