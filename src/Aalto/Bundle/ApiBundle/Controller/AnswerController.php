<?php

namespace Aalto\Bundle\ApiBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Comment;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/answer")
 */
class AnswerController extends Controller
{
    /**
     * Return the list of the most recent answers.
     *
     * @ApiDoc(
     *  description="Return the list of the most recent answers.",
     *  section="Answer",
     *  statusCodes = {
     *    200 = "List of answers",
     *    403 = "Forbidden",
     *    404 = "No answers stored",
     *    500 = "Server error"
     *  },
     * )
     * @Route("/list/recent", name="aalto_api_answer_recent", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listRecentAction(Request $request)
    {
        $limit                   = (int)$request->query->get('limit', 0);
        $mostRecentAnswerManager = $this->get('aalto.manager.answer.most_recent');
        $answers                 = $mostRecentAnswerManager->retrieveNewest($limit);

        if (count($answers) <= 0) {
            $response = new JsonResponse(['error' => 'No answers'], Response::HTTP_NOT_FOUND);
        } else {
            $response = new JsonResponse($answers, Response::HTTP_OK);
        }

        return $response;
    }

    /**
     * Return the list of the most viewed answers for a given user.
     *
     * @ApiDoc(
     *  description="Return the list of the most viewed answers for a given user.",
     *  section="Answer",
     *  statusCodes = {
     *    200 = "List of answers",
     *    403 = "Forbidden",
     *    404 = "No answers stored",
     *    500 = "Server error"
     *  },
     * )
     * @Route("/show/{slug}", name="aalto_api_answer_show", methods={"GET"})
     * @ParamConverter("answer", class="AppBundle:Answer", options={"slug" = "slug"})
     *
     * @param Request $request
     * @param Answer  $answer
     *
     * @return JsonResponse
     */
    public function showAction(Request $request, Answer $answer)
    {
        $params = [
            'title'       => $answer->getTitle(),
            'description' => $answer->getDescription(),
            'createdBy'   => $answer->getUser()->__toString(),
            'createdAt'   => $answer->getCreated(),
            'files'       => [],
            'comments'    => [],
        ];

        $comments = $answer->getComments()->toArray();
        foreach ($comments as $comment) {
            /** @var Comment $comment */
            $params['comments'][] = [
                'text'      => $comment->getContent(),
                'createdBy' => $comment->getUser()->__toString(),
                'createdAt' => $comment->getCreated(),
                'files'     => [],
            ];
        }

        return new JsonResponse($params, Response::HTTP_OK);
    }
}
