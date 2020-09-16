<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="category")
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestions(Question $questions): self
    {
        if (!$this->questions->contains($questions)) {
            $this->questions[] = $questions;
            $questions->setCategory($this);
        }

        return $this;
    }

    public function removeQuestions(Question $questions): self
    {
        if ($this->questions->contains($questions)) {
            $this->questions->removeElement($questions);
            // set the owning side to null (unless already changed)
            if ($questions->getCategory() === $this) {
                $questions->setCategory(null);
            }
        }

        return $this;
    }
}
