<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hability_lv = null;

    #[ORM\Column(length: 1)]
    private ?string $sex = null;

    #[ORM\Column(nullable: true)]
    private ?int $strength = null;

    #[ORM\Column(nullable: true)]
    private ?int $displacement_velocity = null;

    #[ORM\Column(nullable: true)]
    private ?int $reaction_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHabilityLv(): ?int
    {
        return $this->hability_lv;
    }

    public function setHabilityLv(int $hability_lv): self
    {
        $this->hability_lv = $hability_lv;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(?int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDisplacementVelocity(): ?int
    {
        return $this->displacement_velocity;
    }

    public function setDisplacementVelocity(?int $displacement_velocity): self
    {
        $this->displacement_velocity = $displacement_velocity;

        return $this;
    }

    public function getReactionTime(): ?int
    {
        return $this->reaction_time;
    }

    public function setReactionTime(?int $reaction_time): self
    {
        $this->reaction_time = $reaction_time;

        return $this;
    }
}
