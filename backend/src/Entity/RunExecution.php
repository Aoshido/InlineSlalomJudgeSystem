<?php

namespace App\Entity;

use App\Repository\RunExecutionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\LineType;

#[ORM\Entity(repositoryClass: RunExecutionRepository::class)]
class RunExecution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $trickName;

    #[ORM\Column]
    private int $sequenceNumber;

    #[ORM\ManyToOne(inversedBy: 'runExecutions')]
    #[ORM\JoinColumn(nullable: false)]
    private Run $run;

    #[ORM\Column(enumType: LineType::class)]
    private LineType $line;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickName(): ?string
    {
        return $this->trickName;
    }

    public function setTrickName(string $trickName): static
    {
        $this->trickName = $trickName;

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
}
