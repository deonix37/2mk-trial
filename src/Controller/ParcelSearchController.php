<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelDto;
use App\Dto\ParcelSearchDto;
use App\Enum\ParcelSearchType;
use App\Service\ParcelService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class ParcelSearchController extends AbstractController
{
    #[OA\Response(
        response: JsonResponse::HTTP_OK,
        description: 'Получить посылки',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ParcelDto::class))
        )
    )]
    #[OA\Parameter(
        name: 'searchType',
        in: 'query',
        description: <<<END
        Тип поиска:
        - sender_phone - по телефону отправителя;
        - receiver_fullname - по ФИО получателя
        END,
        schema: new OA\Schema(
            type: 'string',
            enum: ParcelSearchType::class,
        ),
        required: true
    )]
    #[OA\Parameter(
        name: 'q',
        in: 'query',
        description: 'Запрос для поиска по выбранному типу',
        schema: new OA\Schema(
            type: 'string',
            example: 'Иванов Иван Иванович'
        ),
        required: true
    )]
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'app_parcel_search', methods: 'GET')]
    public function __invoke(
        #[MapQueryString] ParcelSearchDto $dto,
        ParcelService $parcelService
    ): JsonResponse
    {
        return $this->json($parcelService->findParcels($dto));
    }
}
