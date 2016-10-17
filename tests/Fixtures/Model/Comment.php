<?php

namespace Tests\Fixtures\Model;

class Comment
{
    private $id;
    private $message;
    private $addedAt;

    /**
     * Comment constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->id = uniqid('comm_');
        $this->message = $message;
        $this->addedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function addedAt()
    {
        return $this->addedAt;
    }
}