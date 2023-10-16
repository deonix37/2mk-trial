<?php

declare(strict_types=1);

namespace App\Dto;

final class SenderDto
{
    public function __construct(
        public readonly FullNameDto $fullName,
        public readonly AddressDto $address,
        public readonly string $phone,
    ) {
    }
}
