<?php

namespace App\Entity;

use App\Repository\UserDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDetailsRepository::class)]
class UserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UserName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Password = null;

    #[ORM\Column(nullable: true)]
    private ?int $Otp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(?string $UserName): self
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(?string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getOtp(): ?int
    {
        return $this->Otp;
    }

    public function setOtp(?int $Otp): self
    {
        $this->Otp = $Otp;

        return $this;
    }

}
