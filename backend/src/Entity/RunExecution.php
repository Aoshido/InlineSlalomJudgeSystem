<?php

namespace App\Entity;

use App\Repository\RunExecutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\LineType;

#[ORM\Entity(repositoryClass: RunExecutionRepository::class)]
class RunExecution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'runExecutions')]
    #[ORM\JoinColumn(nullable: false)]
    private Trick $trick;

    #[ORM\Column]
    private int $sequenceNumber;

    #[ORM\ManyToOne(inversedBy: 'runExecutions')]
    #[ORM\JoinColumn(nullable: false)]
    private Run $run;

    #[ORM\Column(enumType: LineType::class)]
    private LineType $line;

    /**
     * @var Collection<int, JudgeScore>
     */
    #[ORM\OneToMany(targetEntity: JudgeScore::class, mappedBy: 'runExecution', orphanRemoval: true)]
    private Collection $judgeScores;

    public function __construct()
    {
        $this->judgeScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function setTrick(Trick $trick): static
    {
        $this->trick = $trick;

        return $this;
    }

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    public function getRun(): ?Run
    {
        return $this->run;
    }

    public function setRun(?Run $run): static
    {
        $this->run = $run;

        return $this;
    }

    public function getLine(): LineType
    {
        return $this->line;
    }

    public function setLine(LineType $line): static
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @return Collection<int, JudgeScore>
     */
    public function getJudgeScores(): Collection
    {
        return $this->judgeScores;
    }

    public function addJudgeScore(JudgeScore $judgeScore): static
    {
        if (!$this->judgeScores->contains($judgeScore)) {
            $this->judgeScores->add($judgeScore);
            $judgeScore->setRunExecution($this);
        }

        return $this;
    }

    public function removeJudgeScore(JudgeScore $judgeScore): static
    {
        $this->judgeScores->removeElement($judgeScore);

        return $this;
    }
}
