<?php

namespace SamJ\FractalBundle;

use League\Fractal\Scope;

class ContainerAwareScope extends Scope
{
    use ContainerAwareTrait;

    /**
     * Fire the main transformer.
     *
     * @internal
     * @param  callable|\League\Fractal\TransformerAbstract  $transformer
     * @param  mixed  $data
     * @return array
     */
    protected function fireTransformer($transformer, $data)
    {
        if (is_string($transformer) && $this->container->has($transformer)) {
            $transformer = $this->container->get($transformer);
        }

        return parent::fireTransformer($transformer, $data);
    }
}
