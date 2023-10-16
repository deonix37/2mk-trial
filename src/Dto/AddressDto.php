<?php

declare(strict_types=1);

namespace App\Dto;

final class AddressDto
{
    public function __construct(
        public readonly string $country,
        public readonly string $city,
        public readonly string $street,
        public readonly string $building,
        public readonly string $apartment
    ) {
    }
}
