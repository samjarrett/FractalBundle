<?php

namespace Tests\Fixtures\Controller;

use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Request;

trait FractalTrait
{
    /**
     * @return Manager
     */
    protected function fractal(Request $request)
    {
        /** @var Manager $manager */
        $manager = $this->get('sam_j_fractal.manager');
        if ($request->query->has('include')) {
            $manager->parseIncludes($request->query->get('include'));
        }

        return $manager;
    }
}
