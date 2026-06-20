<?php

namespace App\Entity;

use App\Repository\JudgeScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JudgeScoreRepository::class)]
class JudgeScore
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $score;

    #[ORM\ManyToOne(inversedBy: 'judgeScores')]
    #[ORM\JoinColumn(nullable: false)]
    private Judge $judge;

    #[ORM\ManyToOne(inversedBy: 'judgeScores')]
    #[ORM\JoinColumn(nullable: false)]
    private RunExecution $runExecution;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getJudge(): ?Judge
    {
        return $this->judge;
    }

    public function setJudge(?Judge $judge): static
    {
        $this->judge = $judge;

        return $this;
    }

    public function getRunExecution(): ?RunExecution
    {
        return $this->runExecution;
    }

    public function setRunExecution(?RunExecution $runExecution): static
    {
        $this->runExecution = $runExecution;

        return $this;
    }
}
