<?php

declare(strict_types=1);

namespace App\Dto;

final class DimensionsDto
{
    public function __construct(
        public readonly int $weight,
        public readonly int $length,
        public readonly int $height,
        public readonly int $width,
    ) {
    }
}
