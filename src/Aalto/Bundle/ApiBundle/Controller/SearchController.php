<?php

namespace Aalto\Bundle\ApiBundle\Controller;

use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * Return the list of the most viewed answers ever.
     *
     * @ApiDoc(
     *  description="Return the list of the most viewed answers ever.",
     *  section="Answer",
     *  statusCodes = {
     *    200 = "List of answers",
     *    403 = "Forbidden",
     *    404 = "No answers stored",
     *    500 = "Server error"
     *  },
     * )
     * @Route("/list/global/most_searched", name="aalto_api_search_global_most_searched", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listMostSearchedAction(Request $request)
    {
        $start                   = $request->query->get('start', 0);
        $limit                   = $request->query->get('limit', 0);
        $mostRecentAnswerManager = $this->get('aalto.manager.answer.most_recent');
        $answers                 = $mostRecentAnswerManager->retrieveMostSearched($start, $limit);

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
     * @Route("/list/most_searched/{email}", name="aalto_api_search_most_searched_user", methods={"GET"})
     * @ParamConverter("user", class="AppBundle:User", options={"email" = "email"})
     *
     * @param Request $request
     * @param User    $user
     *
     * @return JsonResponse
     */
    public function listMostSearchedByUserAction(Request $request, User $user)
    {
        $start                   = $request->query->get('start', 0);
        $limit                   = $request->query->get('limit', 0);
        $mostRecentAnswerManager = $this->get('aalto.manager.answer.most_recent');
        $answers                 = $mostRecentAnswerManager->retrieveMostSearchedByUser($user, $start, $limit);

        if (count($answers) <= 0) {
            $response = new JsonResponse(['error' => 'No answers'], Response::HTTP_NOT_FOUND);
        } else {
            $response = new JsonResponse($answers, Response::HTTP_OK);
        }

        return $response;
    }
}
