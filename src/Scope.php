<?php

namespace SamJ\FractalBundle;

use League\Fractal\Scope as BaseScope;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Scope extends BaseScope implements ContainerAwareInterface {
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * Sets the Container.
	 *
	 * @param ContainerInterface|null $container A ContainerInterface instance or null
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

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
			if ($transformer instanceof ContainerAwareInterface) {
				$transformer->setContainer($this->container);
			}
		}

		return parent::fireTransformer($transformer, $data);
	}
}