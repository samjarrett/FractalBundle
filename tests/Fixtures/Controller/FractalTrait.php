<?php

namespace Tests\Fixtures\Controller;

use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Request;

trait FractalTrait
{

    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * @return Manager
     */
    protected function fractal(Request $request)
    {
        if ($request->query->has('include')) {
            $this->fractal->parseIncludes($request->query->get('include'));
        }

        return $this->fractal;
    }
}
