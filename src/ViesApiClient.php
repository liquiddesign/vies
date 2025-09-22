<?php

namespace Vies;

use Nette\Http\IRequest;
use Tracy\Debugger;
use Vies\Exception\TraderNotFoundException;
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

	public function loadDataByEuVat(string $euVat): ViesResponse
	{
		$response = $this->apiConnection->request(IRequest::Get, '/get/vies/euvat/' . $euVat);

		if ($response->getStatusCode() !== 200) {
			$message = \sprintf('Vies returned an invalid status %d, with message %s', $response->getStatusCode(), $response->getReasonPhrase());
			Debugger::log($message, Debugger::ERROR);

			throw new \RuntimeException($message);
		}

		$responseData = \json_decode($response->getBody()->getContents(), true, 512, \JSON_THROW_ON_ERROR);

		if (isset($responseData['error'])) {
			throw new TraderNotFoundException($responseData['error']['code'], $responseData['error']['description'], $responseData['error']['details']);
		}

		return ViesResponse::fromArray($responseData);
	}
}
