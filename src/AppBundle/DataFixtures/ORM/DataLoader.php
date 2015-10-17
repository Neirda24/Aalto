<?php

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class DataLoader extends AbstractLoader
{
    /**
     * {@inheritdoc}
     */
    public function getFixtures()
    {
        return [
            __DIR__ . '/user.yml',
            __DIR__ . '/answer.yml',
            __DIR__ . '/comment.yml',
            __DIR__ . '/search.yml',
        ];
    }
}
