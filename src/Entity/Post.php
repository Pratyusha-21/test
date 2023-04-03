<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Post = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?string
    {
        return $this->Post;
    }

    public function setPost(?string $Post): self
    {
        $this->Post = $Post;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(?string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }
    public function getTitle(): ?string
    {
        return $this->Post;
    }

    public function setTitle(?string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

}
