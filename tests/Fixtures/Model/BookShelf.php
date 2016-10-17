<?php

namespace Tests\Fixtures\Model;

final class BookShelf
{
    private $books;

    /**
     * BookShelf constructor.
     */
    public function __construct()
    {
        $this->books = [];
    }

    /**
     * @return Book[]
     */
    public function books()
    {
        return $this->books;
    }

    /**
     * @param Book $book
     */
    public function put(Book $book)
    {
        $this->books[] = $book;
    }

    /**
     * @param Book $book
     */
    public function take(Book $book)
    {
        $bookIndex = array_search($book, $this->books, true);
        if (false === $bookIndex) {
            throw new \RuntimeException('There are no requested book on the shelf');
        }

        array_splice($this->books, $bookIndex, 1);
    }

    public function getAvailableAuthors()
    {
        return array_unique(array_map(function (Book $book) {

            return $book->author();
        }, $this->books), SORT_REGULAR);
    }

    /**
     * @param Author $author
     * @param int $limit = 0
     * @return Book[]
     */
    public function getBooksOfTheAuthor(Author $author, $limit = 0)
    {
        $filtered = array_values(
            array_filter($this->books(), function (Book $book) use ($author) {
                return $book->isWrittenBy($author);
            })
        );

        if ($limit > 0) {
            return array_slice($filtered, 0, $limit);
        }

        return $filtered;
    }
}
