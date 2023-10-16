<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Parcel;
use App\Service\ParcelService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelDeleteController extends AbstractController
{
    #[OA\Tag(name: 'Parcel')]
    #[OA\Response(
        response: JsonResponse::HTTP_NO_CONTENT,
        description: 'Удалено'
    )]
    #[Route('/api/parcel/{id}', name: 'app_parcel_delete', methods: 'DELETE')]
    public function __invoke(
        Parcel $parcel,
        ParcelService $parcelService
    ): JsonResponse
    {
        $parcelService->deleteParcel($parcel);

        return $this->json(null, 204);
    }
}
