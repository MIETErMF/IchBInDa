<?php declare(strict_types=1);

namespace App\Scheduler;

use App\ApiClient\OpenAIApiClient;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('midnight')]
final readonly class MidnightAchievementProvider implements ScheduleProviderInterface
{
    public function __construct(private OpenAIApiClient $client)
    {
    }

    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('10 seconds',
                fn() => $this->client->getAchievements()
            )
        );
    }
}
