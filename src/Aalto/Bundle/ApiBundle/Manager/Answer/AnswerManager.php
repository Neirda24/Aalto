<?php

namespace Aalto\Bundle\ApiBundle\Manager\Answer;

use AppBundle\Entity\Answer;
use AppBundle\Entity\User;
use AppBundle\Repository\AnswerRepository;
use AppBundle\Repository\SearchRepository;
use Doctrine\ORM\Query;
use Symfony\Component\Routing\RouterInterface;

class AnswerManager
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
     * @var SearchRepository
     */
    protected $searchRepository;

    /**
     * Constructor.
     *
     * @param AnswerRepository $answerRepository
     * @param SearchRepository $searchRepository
     * @param RouterInterface  $routerInterface
     */
    public function __construct(
        AnswerRepository $answerRepository,
        SearchRepository $searchRepository,
        RouterInterface $routerInterface
    ) {
        $this->answerRepository = $answerRepository;
        $this->searchRepository = $searchRepository;
        $this->routerInterface  = $routerInterface;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function retrieveNewest($limit = 0)
    {
        $answersQuery = $this->answerRepository->findMostRecentQuery($limit);
        $answers      = $answersQuery->getResult();
        $result       = [];

        foreach ($answers as $answer) {
            /** @var Answer $answer */
            $result[] = [
                'title'       => $answer->getTitle(),
                'description' => $answer->getDescription(),
                'uri'         => $this->routerInterface->generate('aalto_api_answer_show', [
                    'slug' => $answer->getSlug()
                ]),
            ];
        }

        return $result;
    }

    /**
     * @param User $user
     * @param int  $start
     * @param int  $limit
     *
     * @return array
     */
    public function retrieveMostSearchedByUser(User $user, $start, $limit)
    {
        $query = $this->searchRepository->findMostSearchedByUserQuery($user, $start, $limit);

        return $this->processMostSearchedQuery($query);
    }

    /**
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function retrieveMostSearched($start, $limit)
    {
        $query = $this->searchRepository->findMostSearchedQuery($start, $limit);

        return $this->processMostSearchedQuery($query);
    }

    /**
     * @param Query $query
     *
     * @return array
     */
    protected function processMostSearchedQuery(Query $query)
    {
        $resultQuery = $query->getArrayResult();
        $result      = [];

        foreach ($resultQuery as $answerArray) {
            $result[] = [
                'title'       => $answerArray['title'],
                'description' => $answerArray['description'],
                'uri'         => $this->routerInterface->generate('aalto_api_answer_show', [
                    'slug' => $answerArray['slug']
                ]),
            ];
        }

        return $result;
    }
}
