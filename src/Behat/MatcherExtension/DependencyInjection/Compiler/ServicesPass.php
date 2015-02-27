<?php

namespace Behat\MatcherExtension\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach (array_keys($container->findTaggedServiceIds('behat.matcher.provider')) as $id) {
            $fakerDefinition = $container->getDefinition($id);
            $fakerDefinition->addMethodCall('resolveArguments');
        }
    }
}
