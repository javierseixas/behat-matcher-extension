<?php

namespace Behat\MatcherExtension;

use Behat\RestExtension\ServiceContainer\HttpClient\Extension as HttpClientExtension;
use Behat\Testwork\ServiceContainer\Extension as BehatExtension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\MatcherExtension\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Extension implements BehatExtension
{
    /**
     * @var HttpClientExtension[]
     */
    private $httpClientExtensions = array();

    public function __construct()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigKey()
    {
        return 'behat_matcher';
    }

    /**
     * {@inheritDoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {

        $differ = $builder->children()->scalarNode('differ');
        $differ->defaultValue('coduo');

    }

    /**
     * {@inheritDoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/ServiceContainer/config'));
        $loader->load('services.xml');
        $loader->load('differs.xml');


        $container->addCompilerPass(new DependencyInjection\Compiler\ServicesPass());

        $container->setAlias('behat.rest.differ', 'behat.matcher.differ.'.$config['differ']);

    }

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
}
