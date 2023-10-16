<?php

use App\Dto\AddressDto;
use App\Dto\DimensionsDto;
use App\Dto\FullNameDto;
use App\Dto\ParcelCreateDto;
use App\Dto\ParcelSearchDto;
use App\Dto\RecipientDto;
use App\Dto\SenderDto;
use App\Entity\Parcel;
use App\Enum\ParcelSearchType;
use App\Repository\ParcelRepository;
use App\Service\ParcelService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ParcelServiceTest extends TestCase
{
    private MockObject $entityManager;
    private MockObject $parcelRepository;
    private ParcelService $parcelService;

    public function setUp(): void
    {
        $this->parcelRepository = $this->createMock(ParcelRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->parcelService = new ParcelService($this->entityManager);
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->parcelRepository);
    }

    public function testFindParcelsBySenderPhone()
    {
        $parcel = new Parcel;

        $this->parcelRepository->expects($this->once())
            ->method('findBySenderPhone')
            ->willReturn([$parcel]);

        $result = $this->parcelService->findParcels(
            new ParcelSearchDto(
                ParcelSearchType::SENDER_PHONE,
                '79998887766'
            )
        );

        $this->assertEquals([$parcel], $result);
    }

    public function testFindParcelsByReceiverFullName()
    {
        $parcel = new Parcel;

        $this->parcelRepository->expects($this->once())
            ->method('findByReceiverFullName')
            ->willReturn([$parcel]);

        $result = $this->parcelService->findParcels(
            new ParcelSearchDto(
                ParcelSearchType::RECEIVER_FULLNAME,
                'Иванов Иван Иванович'
            )
        );

        $this->assertEquals([$parcel], $result);
    }

    public function testCreateParcel()
    {
        $this->entityManager->expects($this->atLeastOnce())
            ->method('persist');
        $this->entityManager->expects($this->once())
            ->method('flush');

        $parcel = $this->parcelService->createParcel(
            new ParcelCreateDto(
                new SenderDto(
                    new FullNameDto('Иван', 'Иванов', 'Иванович'),
                    new AddressDto('Россия', 'СПб', 'Марата', '1', '1'),
                    '79998887766'
                ),
                new RecipientDto(
                    new FullNameDto('Иван', 'Иванов', 'Иванович'),
                    new AddressDto('Россия', 'СПб', 'Марата', '1', '1'),
                    '79998887766'
                ),
                new DimensionsDto(1, 2, 3, 4),
                100
            )
        );

        $this->assertInstanceOf(Parcel::class, $parcel);
    }

    public function testDeleteParcel()
    {
        $parcel = new Parcel;

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($parcel);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->parcelService->deleteParcel($parcel);
    }
}
