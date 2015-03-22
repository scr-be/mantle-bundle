<?php

namespace Scribe\MantleBundle\Entity;
use Scribe\Entity\AbstractEntity;

/**
 * NewsletterUser
 */
class NewsletterUser extends AbstractEntity
{
    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return NewsletterUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

/* EOF */
