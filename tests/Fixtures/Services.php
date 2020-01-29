<?php

namespace Tests\Fixtures;

use Tests\Fixtures\Model\BookShelf;
use Tests\Fixtures\Transformer\AuthorTransformer;
use Tests\Fixtures\Transformer\BookTransformer;
use Tests\Fixtures\Transformer\CommentTransformer;

class Services
{
    // fractal transformers
    const BOOKS_TRANSFORMER = BookTransformer::class;
    const AUTHORS_TRANSFORMER = AuthorTransformer::class;
    const COMMENTS_TRANSFORMER = CommentTransformer::class;

    // repositories
    const BOOK_SHELF = BookShelf::class;
}
