<?php

namespace Tests\Fixtures\Controller;

use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixtures\Services;

class BooksController extends Controller
{
    use FractalTrait;

    public function listOfBooksAction(Request $request)
    {
        $shelf = $this->get(Services::BOOK_SHELF);
        $resource = new Collection($shelf->books(), Services::BOOKS_TRANSFORMER);

        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray()
        );
    }
}
