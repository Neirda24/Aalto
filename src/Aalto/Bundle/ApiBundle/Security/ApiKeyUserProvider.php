<?php

namespace Aalto\Bundle\ApiBundle\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @param string $username
     *
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return new User(
            $username,
            null,
            ['ROLE_API']
        );
    }

    /**
     * @param UserInterface $user
     *
     * @return void
     *
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
