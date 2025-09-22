<?php

namespace Vies\Schema;

class TraderAddressComponents
{
	public function __construct(
		public string $country,
		public string $postalCode,
		public string $city,
		public string $street,
		public string $streetNumber,
		public string $houseNumber,
		public string $other
	) {
	}
}
