<?php

namespace App\Entity;

use App\Repository\TrickClassificationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\TrickFamily;

#[ORM\Entity(repositoryClass: TrickClassificationRepository::class)]
class TrickClassification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 1)]
    private ?string $grade = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(inversedBy: 'trickClassifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trick $trick = null;

    #[ORM\Column(enumType: TrickFamily::class)]
    private TrickFamily $family;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    public function getFamily(): TrickFamily
    {
        return $this->family;
    }

    public function setFamily(TrickFamily $family): static
    {
        $this->family = $family;

        return $this;
    }
}
