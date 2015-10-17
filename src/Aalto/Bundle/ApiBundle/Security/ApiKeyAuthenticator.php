<?php

namespace Aalto\Bundle\ApiBundle\Security;

use Aalto\Bundle\ApiBundle\AaltoApiConstants as Consts;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * Constructor
     *
     * @param ApiKeyUserProvider $userProvider
     * @param TokenGenerator     $tokenGenerator
     */
    public function __construct(ApiKeyUserProvider $userProvider, TokenGenerator $tokenGenerator)
    {
        $this->userProvider   = $userProvider;
        $this->tokenGenerator = $tokenGenerator;
        $this->logger         = null;
    }

    /**
     * @var ApiKeyUserProvider
     */
    protected $userProvider;

    /**
     * @var TokenGenerator
     */
    protected $tokenGenerator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $loggerInterface
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;

        return $this;
    }

    /**
     * @param Request $request
     * @param string  $providerKey
     *
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        // look for an x-api-token header parameter
        $apiKey = trim($request->headers->get(Consts::SESSION_API_KEY, null));

        if ($this->logger instanceof LoggerInterface) {
            $this->logger->debug('[' . __METHOD__ . '] Header[`' . Consts::SESSION_API_KEY . '`] = `' . $apiKey . '`.');
        }

        if ('' === $apiKey) {
            throw new BadCredentialsException('You are not allowed');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    /**
     * @param TokenInterface        $token
     * @param UserProviderInterface $userProvider
     * @param string                $providerKey
     *
     * @return PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $apiKey = $token->getCredentials();
        $valid  = ($this->tokenGenerator->getToken() === $apiKey);

        if (!$valid) {
            throw new AuthenticationException(
                sprintf('API Key "%s" does not exist.', $apiKey)
            );
        }

        $user = $this->userProvider->loadUserByUsername('api');

        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed.", 403);
    }
}
