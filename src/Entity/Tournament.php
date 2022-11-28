<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
#[ApiResource]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $event_description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 3)]
    private ?string $country = null;

    #[ORM\Column(length: 1)]
    private ?string $sex = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Player $champion = null;

    #[ORM\ManyToMany(targetEntity: Player::class, inversedBy: 'tournaments')]
    private Collection $players;

    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Division::class, orphanRemoval: true)]
    private Collection $divisions;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->divisions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->event_description . ' / ' . $this->year . ' - ' . $this->country;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventDescription(): ?string
    {
        return $this->event_description;
    }

    public function setEventDescription(string $event_description): self
    {
        $this->event_description = $event_description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getChampion(): ?Player
    {
        return $this->champion;
    }

    public function setChampion(?Player $champion): self
    {
        $this->champion = $champion;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        $this->players->removeElement($player);

        return $this;
    }

    /**
     * @return Collection<int, Division>
     */
    public function getDivisions(): Collection
    {
        return $this->divisions;
    }

    public function addDivision(Division $division): self
    {
        if (!$this->divisions->contains($division)) {
            $this->divisions->add($division);
            $division->setTournament($this);
        }

        return $this;
    }

    public function removeDivision(Division $division): self
    {
        if ($this->divisions->removeElement($division)) {
            // set the owning side to null (unless already changed)
            if ($division->getTournament() === $this) {
                $division->setTournament(null);
            }
        }

        return $this;
    }
}
