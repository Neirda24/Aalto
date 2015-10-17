<?php

namespace Aalto\Bundle\ApiBundle\Manager\Answer;

use AppBundle\Entity\Answer;
use AppBundle\Repository\AnswerRepository;
use Symfony\Component\Routing\RouterInterface;

class MostRecent
{
    /**
     * @var AnswerRepository
     */
    protected $answerRepository;

    /**
     * @var RouterInterface
     */
    protected $routerInterface;

    /**
     * Constructor.
     *
     * @param AnswerRepository $answerRepository
     * @param RouterInterface  $routerInterface
     */
    public function __construct(AnswerRepository $answerRepository, RouterInterface $routerInterface)
    {
        $this->answerRepository = $answerRepository;
        $this->routerInterface = $routerInterface;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function get($limit = 0)
    {
        $answersQuery = $this->answerRepository->findMostRecentQuery($limit);
        $answers = $answersQuery->getResult();
        $result = [];

        foreach ($answers as $answer) {
            /** @var Answer $answer */
            $result[] = [
                'title' => $answer->getTitle(),
                'description' => $answer->getDescription(),
                'uri' => $this->routerInterface->generate('aalto_front_answer_show', [
                    'slug' => $answer->getSlug()
                ]),
            ];
        }

        return $result;
    }
}
