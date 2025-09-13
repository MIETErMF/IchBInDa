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

    #[Route('/all-achievements', name: 'all-achievements')]
    public function getAllAchievements(): Response
    {
        $allAchievements = $this->achievementRepository->findAll();

        return $this->render('achievements.html.twig', [
            'achievements' => array_filter($allAchievements, function (Achievement $item) {
                return strlen($item->getName()) > 3;
            })
        ]);
    }

    #[Route('/achievements', name: 'achievements')]
    public function getAchievements(): Response
    {
        $randomAchievementsWithPower1 = $this->achievementRepository->getRandomAchievementsWithPower(power: 1, maxResults: 2);
        $randomAchievementsWithPower2 = $this->achievementRepository->getRandomAchievementsWithPower(power: 2, maxResults: 1);
        $randomAchievementsWithPower3 = $this->achievementRepository->getRandomAchievementsWithPower(power: 3, maxResults: 1);
        return $this->render('achievements.html.twig', [
            'achievements' => array_merge($randomAchievementsWithPower1, $randomAchievementsWithPower2, $randomAchievementsWithPower3)]);
    }

    #[Route('/gen', name: 'generate')]
    public function generate(): RedirectResponse
    {
        $this->client->getAchievements();
        return $this->redirectToRoute('all-achievements');
    }

    #[Route('/cleanup', name: 'cleanup')]
    public function cleanup(): RedirectResponse
    {
        $this->achievementRepository->createQueryBuilder('a')
            ->delete()
            ->getQuery()
            ->execute();

        return $this->redirectToRoute('all-achievements');
    }
}
