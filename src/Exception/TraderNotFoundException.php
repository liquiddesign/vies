<?php

namespace Vies\Exception;

use Throwable;

class TraderNotFoundException extends \RuntimeException
{
	public function __construct(int $internalCode, string $description, string $details, ?Throwable $previous = null)
	{
		$message = \sprintf('VIES ERROR %d: %s - %s', $internalCode, $description, $details);

		parent::__construct($message, $internalCode, $previous);
	}
}
