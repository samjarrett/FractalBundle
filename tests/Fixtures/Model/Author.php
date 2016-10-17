<?php

namespace Tests\Fixtures\Model;

final class Author
{
    private $id;
    private $name;

    /**
     * Author constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->id = uniqid('author_', true);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }
}
