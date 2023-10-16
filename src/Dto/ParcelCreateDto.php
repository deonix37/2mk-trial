<?php

declare(strict_types=1);

namespace App\Dto;

final class ParcelCreateDto
{
    public function __construct(
        public readonly SenderDto $sender,
        public readonly RecipientDto $recipient,
        public readonly DimensionsDto $dimensions,
        public readonly int $estimatedCost
    ) {
    }
}
