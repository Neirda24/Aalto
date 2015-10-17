<?php

namespace Aalto\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Test if you can access the API
     *
     * @ApiDoc(
     *  description="Test if you can access the API",
     *  section="Test",
     *  statusCodes = {
     *    200 = "It works",
     *    403 = "Forbidden",
     *    500 = "Server error"
     *  },
     * )
     * @Route("/test", name="aalto_api_default_test", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function testAction()
    {
        return new JsonResponse(['message' => 'It works'], Response::HTTP_OK);
    }
}
