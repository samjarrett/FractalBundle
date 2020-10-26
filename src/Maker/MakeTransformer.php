<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SamJ\FractalBundle\Maker;

use App\FractalTrait;
use League\Fractal\TransformerAbstract;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @author fd6130 <https://github.com/fd6130>
 */
class MakeTransformer extends AbstractMaker
{

    public static function getCommandName(): string
    {
        return 'make:fractal:transformer';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new transformer class')
            ->addArgument('transformer_name', InputArgument::OPTIONAL, 'Choose a class name for your transformer (e.g. <fg=yellow>UserTransformer</>)')
            ->addArgument('entity_name', InputArgument::OPTIONAL, 'Which entity you gonna use for this transformer? (e.g. <fg=yellow>User</>)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeTransformer.txt'))
        ;

        //$inputConf->setArgumentAsNonInteractive('event');
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command)
    {
        
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $transformerClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('transformer_name'),
            'Transformer\\',
            'Transformer'
        );

        $entityClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('entity_name'),
            'Entity\\'
        );

        $entityClassExists = class_exists($entityClassNameDetails->getFullName());

        while(!$entityClassExists)
        {
            $io->error(sprintf('Could not find entity \'%s\'', $entityClassNameDetails->getFullName()));
            $entityClass = $io->ask('Which entity you gonna use for this transformer? (e.g. <fg=yellow>User</>)');
            $entityClassNameDetails = $generator->createClassNameDetails(
                $entityClass,
                'Entity\\'
            );

            $entityClassExists = class_exists($entityClassNameDetails->getFullName());
        }

        $entityVariableName = Str::asLowerCamelCase($input->getArgument('entity_name'));

        $generator->generateClass(
            $transformerClassNameDetails->getFullName(),
            __DIR__.'/../Resources/skeleton/transformer/Transformer.tpl.php',
            [
                'entity_short_class_name' => $entityClassNameDetails->getShortName(),
                'entity_variable_name' => Str::asLowerCamelCase($entityClassNameDetails->getShortName()),
                'entity_full_class_name' => $entityClassNameDetails->getFullName(),
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next: Open your new transformer class and start customizing it.',
            'Find the documentation at <fg=yellow>https://github.com/samjarrett/FractalBundle</>',
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(TransformerAbstract::class,'samj/fractal-bundle');
    }
}