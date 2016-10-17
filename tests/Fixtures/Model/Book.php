<?php

namespace Tests\Fixtures\Model;

class Book
{
    private $id;
    private $name;
    private $author;
    private $comments;
    private $addedAt;

    /**
     * Book constructor.
     * @param string $name
     * @param Author $author
     */
    public function __construct($name, Author $author)
    {
        $this->id = uniqid('book_');
        $this->name = $name;
        $this->author = $author;
        $this->comments = [];
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
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Author
     */
    public function author()
    {
        return $this->author;
    }

    public function isWrittenBy(Author $author)
    {
        return $this->author->id() === $author->id();
    }

    public function comment($message)
    {
        array_unshift($this->comments, new Comment($message));
    }

    /**
     * @return Comment[]
     */
    public function comments($limit = 0)
    {
        if ($limit > 0) {
            return array_slice($this->comments, 0, $limit);
        }

        return $this->comments;
    }

    /**
     * @return \DateTime
     */
    public function addedAt()
    {
        return $this->addedAt;
    }
}