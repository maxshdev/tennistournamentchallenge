<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DivisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DivisionRepository::class)]
#[ApiResource]
class Division
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $phase = null;

    #[ORM\Column(length: 1)]
    private ?string $panel = null;

    #[ORM\ManyToMany(targetEntity: Player::class)]
    private Collection $tuples;

    #[ORM\ManyToOne]
    private ?Player $winner = null;

    #[ORM\ManyToOne(inversedBy: 'divisions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    public function __construct()
    {
        $this->tuples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(string $phase): self
    {
        $this->phase = $phase;

        return $this;
    }

    public function getPanel(): ?string
    {
        return $this->panel;
    }

    public function setPanel(string $panel): self
    {
        $this->panel = $panel;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getTuples(): Collection
    {
        return $this->tuples;
    }

    public function addTuple(Player $tuple): self
    {
        if (!$this->tuples->contains($tuple)) {
            $this->tuples->add($tuple);
        }

        return $this;
    }

    public function removeTuple(Player $tuple): self
    {
        $this->tuples->removeElement($tuple);

        return $this;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }
}
