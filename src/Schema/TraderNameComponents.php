<?php

namespace Vies\Schema;

class TraderNameComponents
{
	public function __construct(
		public string $name,
		public string $legalForm,
		public int $legalFormCanonicalId,
		public string $legalFormCanonicalName
	) {
	}
}
