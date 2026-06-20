<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: RunExecution::class)]
    private Collection $runExecutions;

    /**
     * @var Collection<int, TrickClassification>
     */
    #[ORM\OneToMany(targetEntity: TrickClassification::class, mappedBy: 'trick', orphanRemoval: true)]
    private Collection $trickClassifications;

    public function __construct()
    {
        $this->trickExecutions = new ArrayCollection();
        $this->trickClassifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, TrickClassification>
     */
    public function getTrickClassifications(): Collection
    {
        return $this->trickClassifications;
    }

    public function addTrickClassification(TrickClassification $trickClassification): static
    {
        if (!$this->trickClassifications->contains($trickClassification)) {
            $this->trickClassifications->add($trickClassification);
            $trickClassification->setTrick($this);
        }

        return $this;
    }

    public function removeTrickClassification(TrickClassification $trickClassification): static
    {
        if ($this->trickClassifications->removeElement($trickClassification)) {
            // set the owning side to null (unless already changed)
            if ($trickClassification->getTrick() === $this) {
                $trickClassification->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RunExecution>
     */
    public function getRunExecutions(): Collection
    {
        return $this->runExecutions;
    }

    public function addRunExecution(RunExecution $runExecution): static
    {
        if (!$this->runExecutions->contains($runExecution)) {
            $this->runExecutions->add($runExecution);
            $runExecution->setTrick($this);
        }

        return $this;
    }

    public function removeRunExecution(RunExecution $runExecution): static
    {
        if ($this->runExecutions->removeElement($runExecution)) {
            if ($runExecution->getTrick() === $this) {
                $runExecution->setTrick(null);
            }
        }

        return $this;
    }
}
