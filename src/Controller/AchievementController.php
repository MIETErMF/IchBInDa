<?php declare(strict_types=1);

namespace App\Controller;

use App\ApiClient\OpenAIApiClient;
use App\Entity\Achievement;
use App\Repository\AchievementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AchievementController extends AbstractController
{
    public function __construct(
        private readonly AchievementRepository $achievementRepository,
        private readonly OpenAIApiClient       $client
    )
    {
    }

    #[Route('/achievements', name: 'achievements')]
    public function getAchievements(): Response
    {
        $allAchievements = $this->achievementRepository->findAll();

        return $this->render('achievements.html.twig', [
            'achievements' => array_filter($allAchievements, function (Achievement $item) {
                return strlen($item->getName()) > 3;
            })
        ]);
    }

    #[Route('/gen', name: 'generate')]
    public function generate(): RedirectResponse
    {
        $this->client->getAchievements();
        return $this->redirectToRoute('achievements');
    }

    #[Route('/cleanup', name: 'cleanup')]
    public function cleanup(): RedirectResponse
    {
        $this->achievementRepository->createQueryBuilder('a')
            ->delete()
            ->getQuery()
            ->execute();

        return $this->redirectToRoute('achievements');
    }
}
