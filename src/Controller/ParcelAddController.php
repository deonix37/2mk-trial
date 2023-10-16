<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelCreateDto;
use App\Service\ParcelService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ParcelAddController extends AbstractController
{
    #[OA\Tag(name: 'Parcel')]
    #[OA\Response(
        response: JsonResponse::HTTP_CREATED,
        description: 'Создано',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'id',
                    type: 'integer'
                )
            ]
        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            type: 'object',
            ref: new Model(type: ParcelCreateDto::class)
        ),
        required: true
    )]
    #[Route('/api/parcel', name: 'api_parcel_add', methods: 'POST')]
    public function __invoke(
        #[MapRequestPayload] ParcelCreateDto $dto,
        ParcelService $parcelService
    ): JsonResponse
    {
        $parcel = $parcelService->createParcel($dto);

        return $this->json(['id' => $parcel->getId()]);
    }
}
