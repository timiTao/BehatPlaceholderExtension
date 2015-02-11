<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\PlaceholderExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\ServiceContainer\ServiceProcessor;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class Extension
 *
 * @package Behat\PlaceholderExtension\ServiceContainer
 */
class Extension implements ExtensionInterface
{

    /**
     * Main service name
     */
    const SERVICE_NAME = 'placeholder';

    /**
     * Registration tag for object mappers
     */
    const OBJECT_MAPPER_REGISTRATION_TAG = 'placeholder.object_mapper.register';

    /**
     *
     */
    const MAPPER_COLLECTION_ID = 'placeholder.mapper.collection';

    /**
     * @var ServiceProcessor
     */
    private $processor;

    /**
     * Initializes compiler pass.
     *
     * @param null|ServiceProcessor $processor
     */
    public function __construct(ServiceProcessor $processor = null)
    {
        $this->processor = $processor ? : new ServiceProcessor();
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $this->processObjectMapperRegistration($container);
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return Extension::SERVICE_NAME;
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('pattern')->defaultValue('/placeholder\(([a-zA-Z0-9_\.\-]+)\)/')->info(
                'All values that match PATTERN will be try to transform.'
            )->end()
            ->arrayNode('defaults')
            ->prototype('scalar')
            ->end();
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Config'));
        $loader->load('services.yml');

        $container->setParameter(Extension::SERVICE_NAME . '.config', $config);
        $container->setParameter(Extension::SERVICE_NAME . '.config.pattern', $config['pattern']);
        $container->setParameter(Extension::SERVICE_NAME . '.config.defaults', $config['defaults']);
    }

    /**
     * Processes all search engines in the container.
     *
     * @param ContainerBuilder $container
     */
    private function processObjectMapperRegistration(ContainerBuilder $container)
    {
        $references = $this->processor->findAndSortTaggedServices($container, Extension::OBJECT_MAPPER_REGISTRATION_TAG);
        $definition = $container->getDefinition(Extension::MAPPER_COLLECTION_ID);
        foreach ($references as $reference) {
            $definition->addMethodCall('add', array($reference));
        }
    }
}
