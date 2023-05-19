<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: 'email',
    message: "Cette adresse email existe déjà."
)]
#[UniqueEntity(
    fields: 'username',
    message: "Ce pseudo est déjà utilisé."
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull(
        message: "Vous devez indiquer une email valide."
    )]
    #[Assert\Length(
        min: 3,
        max: 18,
        minMessage: "Votre pseudo est trop court (min : 3)",
        maxMessage: "Votre pseudo est trop long (max : 18)"
    )]
    #[Assert\Regex(
        pattern: "/@/",
        match: false,
        message: "Le pseudonyme indiqué n'est pas valide"
    )
    ]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull(
        message: "Vous devez indiquer une email valide."
    )]
    #[Assert\Email(
        message: "L'email indiqué n'est pas valide."
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(
        message: "Vous devez indiquer un mot de passe."
    )]
    private ?string $password = null;

    #[Assert\NotNull(
        message: "Vous devez confirmer le mot de passe."
    )]
    #[Assert\EqualTo(
        propertyPath: 'password',
        message: "Vos mots de passe ne sont pas identiques."
    )]
    private ?string $passwordConfirm = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?bool $banned = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(?string $passwordConfirm): void
    {
        $this->passwordConfirm = $passwordConfirm;
    }
}
