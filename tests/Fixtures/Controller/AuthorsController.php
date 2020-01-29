<?php

namespace Tests\Fixtures\Controller;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixtures\Model\BookShelf;
use Tests\Fixtures\Services;

class AuthorsController extends AbstractController
{
    use FractalTrait;

    /**
     * @var BookShelf
     */
    private $bookShelf;

    public function __construct(BookShelf $bookShelf, Manager $manager)
    {
        $this->bookShelf = $bookShelf;
        $this->fractal   = $manager;
    }

    public function listOfAuthorsAction(Request $request)
    {
        $authors = $this->bookShelf->getAvailableAuthors();

        $resource = new Collection($authors, Services::AUTHORS_TRANSFORMER);

        return new JsonResponse(
            $this->fractal($request)->createData($resource)->toArray()
        );
    }
}
