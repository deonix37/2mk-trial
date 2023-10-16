<?php

namespace App\Service;

use App\Dto\ParcelCreateDto;
use App\Dto\ParcelSearchDto;
use App\Entity\Address;
use App\Entity\Dimensions;
use App\Entity\FullName;
use App\Entity\Parcel;
use App\Entity\Recipient;
use App\Entity\Sender;
use App\Enum\ParcelSearchType;
use Doctrine\ORM\EntityManagerInterface;

class ParcelService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findParcels(ParcelSearchDto $dto): array
    {
        $repository = $this->entityManager->getRepository(Parcel::class);

        switch ($dto->searchType) {
            case ParcelSearchType::SENDER_PHONE:
                return $repository->findBySenderPhone($dto->q);
            case ParcelSearchType::RECEIVER_FULLNAME:
                return $repository->findByReceiverFullName($dto->q);
        }
    }

    public function createParcel(ParcelCreateDto $dto): Parcel
    {
        $senderFullName = new FullName;
        $senderFullName->setFirstName($dto->sender->fullName->firstName);
        $senderFullName->setLastName($dto->sender->fullName->lastName);
        $senderFullName->setMiddleName($dto->sender->fullName->middleName);

        $senderAddress = new Address;
        $senderAddress->setCountry($dto->sender->address->country);
        $senderAddress->setCity($dto->sender->address->city);
        $senderAddress->setStreet($dto->sender->address->street);
        $senderAddress->setBuilding($dto->sender->address->building);
        $senderAddress->setApartment($dto->sender->address->apartment);

        $sender = new Sender;
        $sender->setFullName($senderFullName);
        $sender->setAddress($senderAddress);
        $sender->setPhone($dto->sender->phone);

        $recipientFullName = new FullName;
        $recipientFullName->setFirstName($dto->recipient->fullName->firstName);
        $recipientFullName->setLastName($dto->recipient->fullName->lastName);
        $recipientFullName->setMiddleName($dto->recipient->fullName->middleName);

        $recipientAddress = new Address;
        $recipientAddress->setCountry($dto->recipient->address->country);
        $recipientAddress->setCity($dto->recipient->address->city);
        $recipientAddress->setStreet($dto->recipient->address->street);
        $recipientAddress->setBuilding($dto->recipient->address->building);
        $recipientAddress->setApartment($dto->recipient->address->apartment);

        $recipient = new Recipient;
        $recipient->setFullName($recipientFullName);
        $recipient->setAddress($recipientAddress);
        $recipient->setPhone($dto->recipient->phone);

        $dimensions = new Dimensions;
        $dimensions->setWeight($dto->dimensions->weight);
        $dimensions->setLength($dto->dimensions->length);
        $dimensions->setWidth($dto->dimensions->width);
        $dimensions->setHeight($dto->dimensions->height);

        $parcel = new Parcel;
        $parcel->setSender($sender);
        $parcel->setRecipient($recipient);
        $parcel->setDimensions($dimensions);
        $parcel->setEstimatedCost($dto->estimatedCost);

        $this->entityManager->persist($senderFullName);
        $this->entityManager->persist($senderAddress);
        $this->entityManager->persist($sender);

        $this->entityManager->persist($recipientFullName);
        $this->entityManager->persist($recipientAddress);
        $this->entityManager->persist($recipient);

        $this->entityManager->persist($dimensions);
        $this->entityManager->persist($parcel);

        $this->entityManager->flush();

        return $parcel;
    }

    public function deleteParcel(Parcel $parcel): void
    {
        $this->entityManager->remove($parcel);
        $this->entityManager->flush();
    }
}
