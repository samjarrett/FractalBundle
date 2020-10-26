<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use League\Fractal\TransformerAbstract;
use <?= $entity_full_class_name ?>;

/**
 * Transformer are use to decorate your output data before serialize it to JSON.
 *
 * Fractal docs: https://fractal.thephpleague.com/transformers
 * Bundle docs: https://github.com/samjarrett/FractalBundle
 */
class <?= $class_name ?> extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */
    public function transform(<?= $entity_short_class_name ?> $<?= $entity_variable_name ?> ): ?array
    {
        // Decorate your return data in array form.
        return [
            'id' => $<?= $entity_variable_name ?>->getId(),
        ];
    }

    /**
     * Write this function if you have declare something in $availableIncludes or $defaultIncludes
     *
     * Example: If you include 'user', the method name and its parameter will be 'public function includeUser(User $user)'
     */
//   public function includeExample(/** entity class */)
//   {
//       return $this->item(/** entity class */, /** transformer class */);
//   }

}