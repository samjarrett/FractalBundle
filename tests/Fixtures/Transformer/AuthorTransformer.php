<?php

namespace Tests\Fixtures\Transformer;

use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use Tests\Fixtures\Model\Author;
use Tests\Fixtures\Model\BookShelf;
use Tests\Fixtures\Services;

class AuthorTransformer extends TransformerAbstract
{
    private $booksShelf;

    protected $availableIncludes = ['books'];

    /**
     * TransformerWithIncludes constructor.
     * @param BookShelf $booksShelf
     */
    public function __construct(BookShelf $booksShelf)
    {
        $this->booksShelf = $booksShelf;
    }

    public function transform(Author $author)
    {
        return [
            'id' => $author->id(),
            'name' => $author->name(),
        ];
    }

    public function includeBooks(Author $author, ParamBag $params = null)
    {
        if (null === $params) {
            $params = new ParamBag(['limit' => []]);
        }

        list($limit) = $params->get('limit');
        $books = $this->booksShelf->getBooksOfTheAuthor($author, $limit);

        return $this->collection($books, Services::BOOKS_TRANSFORMER);
    }
}