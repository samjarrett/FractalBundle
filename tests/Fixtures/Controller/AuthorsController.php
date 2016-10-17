<?php

namespace Tests\Fixtures\Controller;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixtures\Services;

class AuthorsController extends Controller
{
    use FractalTrait;

    public function listOfAuthorsAction(Request $request)
    {
        $shelf = $this->get(Services::BOOK_SHELF);
        $authors = $shelf->getAvailableAuthors();

        $resource = new Collection($authors, Services::AUTHORS_TRANSFORMER);

        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray()
        );
    }


}
