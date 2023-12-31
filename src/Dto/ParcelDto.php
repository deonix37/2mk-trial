<?php

declare(strict_types=1);

namespace App\Dto;

final class ParcelDto
{
    public function __construct(
        public readonly int $id,
        public readonly SenderDto $sender,
        public readonly RecipientDto $recipient,
        public readonly DimensionsDto $dimensions,
        public readonly int $estimatedCost
    ) {
    }
}
