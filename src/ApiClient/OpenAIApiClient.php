<?php declare(strict_types=1);

namespace App\ApiClient;

use App\Entity\Achievement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class OpenAIApiClient
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $em,
        #[Autowire('%env(OPEN_AI_API_KEY)%')]
        private string $openAiApiKey
    )
    {
    }

    public function getAchievements(): array
    {
        $response = $this->client->request(
            'POST',
            'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '. $this->openAiApiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'max_tokens' => 350,
                    'temperature' => 1,
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => '  You are a helpful assistant. I am 14 years old and I want you to generate 4 achievable personal tasks.

                                            A short and simple action I can complete today; make it varied and not repetitive.
                                            Another light action I can do today; make it different from the first.
                                            A moderate challenge I can complete this week; change the type every week.
                                            A long-term or difficult task I can work on this month; change the type every month.

                                            Strict output rules:
                                            - Output exactly 4 lines separated by a single LF newline character (\n).
                                            - Each line is one short English sentence.
                                            - No leading or trailing spaces on any line.
                                            - No blank lines anywhere (not at the start, between lines, or at the end).
                                            - No numbering, bullets, quotes, tags, or extra text.
                                            - Do not repeat the same wording across lines.
                                '
                        ]
                    ]
                ]
            ]
        );

        $data = $response->toArray();

        $content = $data['choices'][0]['message']['content'];
        $achievements = explode("\n", $content);

        $achievement1 = new Achievement();
        $achievement1
            ->setName($achievements[0])
            ->setPower(1)
            ->setCreatedAt(new \DateTimeImmutable('now'));
        $this->em->persist($achievement1);

        $achievement2 = new Achievement();
        $achievement2
            ->setName($achievements[1])
            ->setPower(1)
            ->setCreatedAt(new \DateTimeImmutable('now'));
        $this->em->persist($achievement2);

        $achievement3 = new Achievement();
        $achievement3
            ->setName($achievements[2])
            ->setPower(2)
            ->setCreatedAt(new \DateTimeImmutable('now'));
        $this->em->persist($achievement3);

        $achievement4 = new Achievement();
        $achievement4
            ->setName($achievements[3])
            ->setPower(3)
            ->setCreatedAt(new \DateTimeImmutable('now'));
        $this->em->persist($achievement4);


        $this->em->flush();

        return [$achievement1,$achievement2,$achievement3,$achievement4];
    }
}
