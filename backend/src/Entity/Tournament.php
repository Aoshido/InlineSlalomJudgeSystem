<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8, unique: true)]
    private ?string $key = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Judge>
     */
    #[ORM\OneToMany(targetEntity: Judge::class, mappedBy: 'tournament')]
    private Collection $judges;

    /**
     * @var Collection<int, Run>
     */
    #[ORM\OneToMany(targetEntity: Run::class, mappedBy: 'tournament', orphanRemoval: true)]
    private Collection $runs;

    public function __construct()
    {
        $this->judges = new ArrayCollection();
        $this->runs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

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

    /**
     * @return Collection<int, Judge>
     */
    public function getJudges(): Collection
    {
        return $this->judges;
    }

    public function addJudge(Judge $judge): static
    {
        if (!$this->judges->contains($judge)) {
            $this->judges->add($judge);
            $judge->setTournament($this);
        }

        return $this;
    }

    public function removeJudge(Judge $judge): static
    {
        if ($this->judges->removeElement($judge)) {
            // set the owning side to null (unless already changed)
            if ($judge->getTournament() === $this) {
                $judge->setTournament(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Run>
     */
    public function getRuns(): Collection
    {
        return $this->runs;
    }

    public function addRun(Run $run): static
    {
        if (!$this->runs->contains($run)) {
            $this->runs->add($run);
            $run->setTournament($this);
        }

        return $this;
    }

    public function removeRun(Run $run): static
    {
        if ($this->runs->removeElement($run)) {
            // set the owning side to null (unless already changed)
            if ($run->getTournament() === $this) {
                $run->setTournament(null);
            }
        }

        return $this;
    }
}
