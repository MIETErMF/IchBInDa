<?php declare(strict_types=1);

namespace App\ApiClient;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class UnsplashApiClient
{
    public function __construct(
        private HttpClientInterface    $client,
        #[Autowire('%env(UNSPLASH_SECRET_KEY)%')]
        private string                 $unsplashSecretKey,
        #[Autowire('%env(UNSPLASH_URL)%')]
        private string                 $unsplashUrl,
    )
    {
    }

    public function getImage(): string
    {
        $response = $this->client->request(
            'GET',
            $this->unsplashUrl,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'client_id' => $this->unsplashSecretKey,
                    'query' => 'positive',
                    'orientation' => 'landscape',
                ]
            ]
        );

        $data = $response->toArray();

        $content = $data['urls']['full'];
        return $content;
    }
}
