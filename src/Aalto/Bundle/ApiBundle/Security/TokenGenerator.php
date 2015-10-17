<?php

namespace Aalto\Bundle\ApiBundle\Security;

class TokenGenerator
{
    /**
     * @var string
     */
    protected $token;

    /**
     * Constructor
     *
     * @param string $token
     */
    public function __construct($token = 'token')
    {
        $this->token = trim($token);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
