<?php

namespace Aalto\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/list/recent/{limit}", requirements={"limit":"\d+"}, defaults={"limit":0},
     *                                name="aalto_api_answer_recent", methods={"GET"})
     * @Route("/list/recent", name="aalto_api_answer_recent_nolimit", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function listRecentAction($limit)
    {
        $mostRecentAnswerManager = $this->get('aalto.manager.answer.most_recent');
        $answers                 = $mostRecentAnswerManager->get($limit);

        return new JsonResponse($answers, Response::HTTP_OK);
    }
}
