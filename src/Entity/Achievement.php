<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\AchievementRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\Table(name: 'achievements')]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::INTEGER)]
    private int $power;

    #[ORM\Column(type: Types::TEXT)]
    private string $name;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $done = false;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $seen = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Achievement
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Achievement
    {
        $this->name = $name;
        return $this;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone(bool $done): Achievement
    {
        $this->done = $done;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): Achievement
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getPower(): int
    {
        return $this->power;
    }

    public function setPower(int $power): Achievement
    {
        $this->power = $power;
        return $this;
    }

    public function isSeen(): bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): Achievement
    {
        $this->seen = $seen;
        return $this;
    }


}
