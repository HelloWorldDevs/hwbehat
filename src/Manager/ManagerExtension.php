<?php

namespace HelloWorldDevs\Behat\Manager;

use Behat\Testwork\ServiceContainer\Extension as BehatExtension;
use Behat\Testwork\ServiceContainer\ExtensionManager as BehatExtensionManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ManagerExtension implements BehatExtension
{
  /**
   * {@inheritdoc}
   */
  public function getConfigKey()
  {
    return 'manager';
  }

  /**
   * {@inheritdoc}
   */
  public function initialize(BehatExtensionManager $extensionManager)
  {
    // Initialization code here
  }

  /**
   * {@inheritdoc}
   */
  public function configure(ArrayNodeDefinition $builder)
  {
    // Configuration code here
  }

  /**
   * {@inheritdoc}
   */

  public function load(ContainerBuilder $container, array $config)
  {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yml');
  }

  /**
   * {@inheritdoc}
   */
  public function process(ContainerBuilder $container)
  {
    // Processing services here
  }
}
