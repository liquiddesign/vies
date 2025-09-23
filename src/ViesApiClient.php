<?php

namespace Vies;

use Nette\Http\IRequest;
use Vies\Exception\ViesAPIException;
use Vies\Schema\ViesResponse;

class ViesApiClient
{
	private readonly ApiConnection $apiConnection;

	public function __construct(
		private readonly string $baseUrl,
		private readonly string $login,
		private readonly string $password,
	) {
		$this->apiConnection = new ApiConnection($this->baseUrl, $this->login, $this->password);
	}

	/**
	 * @param string $euVat
	 * @throws \JsonException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \RuntimeException
	 * @throws \Vies\Exception\ViesAPIException
	 */
	public function loadDataByEuVat(string $euVat): ViesResponse
	{
		$response = $this->apiConnection->request(IRequest::Get, '/get/vies/euvat/' . $euVat);

		if ($response->getStatusCode() !== 200) {
			$message = \sprintf('Vies returned an invalid status %d, with message %s', $response->getStatusCode(), $response->getReasonPhrase());

			throw new \RuntimeException($message);
		}

		$stringData = $response->getBody()->getContents();
		$responseData = \json_decode($stringData, true, 512, \JSON_THROW_ON_ERROR);

		if (isset($responseData['error'])) {
			throw new ViesAPIException($responseData['error']['code'], $responseData['error']['description'], $responseData['error']['details']);
		}

		return ViesResponse::fromArray($responseData);
	}
}
