<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $score = 0;

    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'user')]
    private Collection $games;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'players')]
    private Collection $participatedGames;

    #[ORM\OneToMany(targetEntity: GameScore::class, mappedBy: 'user')]
    private Collection $gameScores;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    private int $userScore; 

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->participatedGames = new ArrayCollection();
        $this->gameScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }



    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setUser($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getUser() === $this) {
                $game->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getParticipatedGames(): Collection
    {
        return $this->participatedGames;
    }

    public function addParticipatedGame(Game $participatedGame): static
    {
        if (!$this->participatedGames->contains($participatedGame)) {
            $this->participatedGames->add($participatedGame);
            $participatedGame->addPlayer($this);
        }

        return $this;
    }

    public function removeParticipatedGame(Game $participatedGame): static
    {
        if ($this->participatedGames->removeElement($participatedGame)) {
            $participatedGame->removePlayer($this);
        }

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
            $gameScore->setUser($this);
        }

        return $this;
    }

    public function removeGameScore(GameScore $gameScore): static
    {
        if ($this->gameScores->removeElement($gameScore)) {
            // set the owning side to null (unless already changed)
            if ($gameScore->getUser() === $this) {
                $gameScore->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
