<?php declare(strict_types=1);

namespace App\Controller;

use App\ApiClient\UnsplashApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UnsplashController extends AbstractController
{
    public function __construct(private UnsplashApiClient $client)
    {
    }

    #[Route('/unsplash', name: 'unsplash')]
    public function getImage(): Response
    {
        return new JsonResponse($this->client->getImage(), 200);
    }
}
