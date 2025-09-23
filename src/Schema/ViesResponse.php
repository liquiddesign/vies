<?php

namespace Vies\Schema;

class ViesResponse
{
	public function __construct(
		public string $uid,
		public string $countryCode,
		public string $vatNumber,
		public bool $valid,
		public string $traderName,
		public TraderNameComponents $traderNameComponents,
		public string $traderCompanyType,
		public string $traderAddress,
		public TraderAddressComponents $traderAddressComponents,
		public string $id,
		public string $date,
		public string $source
	) {
	}

	/**
	 * @param array<string, mixed> $data
	 * @throws \InvalidArgumentException
	 */
	public static function fromArray(array $data): self
	{
		if (!isset($data['vies'])) {
			throw new \InvalidArgumentException('Missing vies key in response');
		}

		$viesData = $data['vies'];

		$traderNameComponents = new TraderNameComponents(
			$viesData['traderNameComponents']['name'] ?? '',
			$viesData['traderNameComponents']['legalForm'] ?? '',
			$viesData['traderNameComponents']['legalFormCanonicalId'] ?? 0,
			$viesData['traderNameComponents']['legalFormCanonicalName'] ?? ''
		);

		$traderAddressComponents = new TraderAddressComponents(
			$viesData['traderAddressComponents']['country'] ?? '',
			$viesData['traderAddressComponents']['postalCode'] ?? '',
			$viesData['traderAddressComponents']['city'] ?? '',
			$viesData['traderAddressComponents']['street'] ?? '',
			$viesData['traderAddressComponents']['streetNumber'] ?? '',
			$viesData['traderAddressComponents']['houseNumber'] ?? '',
			$viesData['traderAddressComponents']['other'] ?? ''
		);

		return new self(
			$viesData['uid'] ?? '',
			$viesData['countryCode'] ?? '',
			$viesData['vatNumber'] ?? '',
			$viesData['valid'] ?? false,
			$viesData['traderName'] ?? '',
			$traderNameComponents,
			$viesData['traderCompanyType'] ?? '',
			$viesData['traderAddress'] ?? '',
			$traderAddressComponents,
			$viesData['id'] ?? '',
			$viesData['date'] ?? '',
			$viesData['source'] ?? ''
		);
	}
}
