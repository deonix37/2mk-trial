<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enum\ParcelSearchType;
use Symfony\Component\Validator\Constraints as Assert;

final class ParcelSearchDto
{
    public function __construct(
        public readonly ParcelSearchType $searchType,

        #[Assert\NotBlank]
        public readonly string $q
    ) {
    }

    #[Assert\IsTrue(message: 'Значение не является ФИО.')]
    public function isFullName(): bool
    {
        if ($this->searchType !== ParcelSearchType::RECEIVER_FULLNAME) {
            return true;
        }

        return count(preg_split('/\s+/', $this->q)) === 3;
    }
}
