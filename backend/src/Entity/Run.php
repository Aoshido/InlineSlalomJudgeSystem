<?php

namespace App\Entity;

use App\Repository\RunRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\RunStatus;

#[ORM\Entity(repositoryClass: RunRepository::class)]
class Run
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: RunStatus::class)]
    private RunStatus $status;

    #[ORM\Column]
    private \DateTimeImmutable $startedAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endedAt = null;

    /**
     * @var Collection<int, RunExecution>
     */
    #[ORM\OneToMany(targetEntity: RunExecution::class, mappedBy: 'run', orphanRemoval: true)]
    private Collection $runExecutions;

    #[ORM\ManyToOne(inversedBy: 'runs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\ManyToOne(inversedBy: 'runs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skater $skater = null;

    public function __construct()
    {
        $this->status = RunStatus::LIVE;
        $this->startedAt = new \DateTimeImmutable();
        $this->runExecutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(\DateTimeImmutable $endedAt): static
    {
        $this->endedAt = $endedAt;

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
            $runExecution->setRun($this);
        }

        return $this;
    }

    public function removeRunExecution(RunExecution $runExecution): static
    {
        $this->runExecutions->removeElement($runExecution);

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getSkater(): ?Skater
    {
        return $this->skater;
    }

    public function setSkater(?Skater $skater): static
    {
        $this->skater = $skater;

        return $this;
    }


}
