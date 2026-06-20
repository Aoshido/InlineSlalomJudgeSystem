<?php

namespace App\Controller;

use App\Entity\Judge;
use App\Entity\JudgeScore;
use App\Entity\Run;
use App\Entity\RunExecution;
use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/run')]
class RunController extends AbstractController
{
    #[Route('/{id}', methods: ['GET'])]
    public function getRun(Run $run): JsonResponse
    {
        $data = [];

        foreach ($run->getRunExecutions() as $execution) {
            $scores = [];

            foreach ($execution->getJudgeScores() as $score) {
                $scores[] = [
                    'judge' => $score->getJudge()->getName(),
                    'score' => $score->getScore(),
                ];
            }

            $data[] = [
                'id' => $execution->getId(),
                'trick' => $execution->getTrick()->getName(),
                'line' => $execution->getLine()->value,
                'sequence' => $execution->getSequenceNumber(),
                'scores' => $scores,
            ];
        }

        return $this->json([
            'runId' => $run->getId(),
            'skater' => $run->getSkater()->getName(),
            'executions' => $data,
        ]);
    }

    #[Route('/{id}/execution', methods: ['POST'])]
    public function createExecution(
        Run $run,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $payload = json_decode($request->getContent(), true);

        /** @var Trick $trick */
        $trick = $em->getRepository(Trick::class)->find($payload['trickId']);

        if (!$trick) {
            return $this->json(['error' => 'Trick not found'], 404);
        }

        $execution = new RunExecution();
        $execution->setRun($run);
        $execution->setTrick($trick);
        $execution->setLine(\App\Enum\LineType::from($payload['line']));
        $execution->setSequenceNumber(count($run->getRunExecutions()) + 1);

        $em->persist($execution);
        $em->flush();

        return $this->json([
            'id' => $execution->getId()
        ]);
    }

    #[Route('/execution/{id}/score', methods: ['POST'])]
    public function scoreExecution(
        RunExecution $execution,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $payload = json_decode($request->getContent(), true);

        /** @var Judge $judge */
        $judge = $em->getRepository(Judge::class)->find($payload['judgeId']);

        if (!$judge) {
            return $this->json(['error' => 'Judge not found'], 404);
        }

        $score = new JudgeScore();
        $score->setRunExecution($execution);
        $score->setJudge($judge);
        $score->setScore($payload['score']);

        $em->persist($score);
        $em->flush();

        return $this->json(['ok' => true]);
    }
}
