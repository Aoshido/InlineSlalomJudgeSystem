<?php

namespace App\Entity;

use App\Repository\JudgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JudgeRepository::class)]
class Judge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'judges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    /**
     * @var Collection<int, JudgeScore>
     */
    #[ORM\OneToMany(targetEntity: JudgeScore::class, mappedBy: 'judge', orphanRemoval: true)]
    private Collection $judgeScores;

    public function __construct()
    {
        $this->judgeScores = new ArrayCollection();
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

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

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
            $judgeScore->setJudge($this);
        }

        return $this;
    }

    public function removeJudgeScore(JudgeScore $judgeScore): static
    {
        $this->judgeScores->removeElement($judgeScore);

        return $this;
    }
}
