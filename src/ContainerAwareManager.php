<?php

namespace SamJ\FractalBundle;

use League\Fractal\Manager;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ContainerAwareManager extends Manager implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Create Data.
     *
     * Main method to kick this all off. Make a resource then pass it over, and use toArray()
     *
     * @param ResourceInterface $resource
     * @param string            $scopeIdentifier
     * @param Scope             $parentScopeInstance
     *
     * @return ContainerAwareScope
     */
    public function createData(ResourceInterface $resource, $scopeIdentifier = null,
                               Scope $parentScopeInstance = null)
    {
        $scopeInstance = new ContainerAwareScope($this, $resource, $scopeIdentifier);
        $scopeInstance->setContainer($this->container);

        // Update scope history
        if ($parentScopeInstance !== null) {
            // This will be the new children list of parents (parents parents, plus the parent)
            $scopeArray = $parentScopeInstance->getParentScopes();
            $scopeArray[] = $parentScopeInstance->getScopeIdentifier();

            $scopeInstance->setParentScopes($scopeArray);
        }

        return $scopeInstance;
    }
}
