<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rounds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $rounds = null;

    #[ORM\ManyToMany(targetEntity: City::class, inversedBy: 'games')]
    private Collection $cities;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participatedGames')]
    private Collection $players;

    #[ORM\OneToMany(targetEntity: GameScore::class, mappedBy: 'game')]
    private Collection $gameScores;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    private ?int $userScore;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->players = new ArrayCollection();
        $this->gameScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRounds(): ?int
    {
        return $this->rounds;
    }

    public function setRounds(int $rounds): static
    {
        $this->rounds = $rounds;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
        }

        return $this;
    }

    public function removeCity(City $city): static
    {
        $this->cities->removeElement($city);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(User $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }

        return $this;
    }

    public function removePlayer(User $player): static
    {
        $this->players->removeElement($player);

        return $this;
    }

    /**
     * @return Collection<int, GameScore>
     */
    public function getGameScores(): Collection
    {
        return $this->gameScores;
    }

    public function addGameScore(GameScore $gameScore): static
    {
        if (!$this->gameScores->contains($gameScore)) {
            $this->gameScores->add($gameScore);
            $gameScore->setGame($this);
        }

        return $this;
    }

    public function removeGameScore(GameScore $gameScore): static
    {
        if ($this->gameScores->removeElement($gameScore)) {
            // set the owning side to null (unless already changed)
            if ($gameScore->getGame() === $this) {
                $gameScore->setGame(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function setUserScore(?int $userScore): self
    {
        $this->userScore = $userScore;

        return $this;
    }

    public function getUserScore():?int {
        return $this->userScore;
    }
}
