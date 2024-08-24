<?php

namespace HelloWorldDevs\Behat\Manager;

use Behat\Testwork\ServiceContainer\Extension as BehatExtension;
use Behat\Testwork\ServiceContainer\ExtensionManager as BehatExtensionManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

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
    $definition = new Definition('HelloWorldDevs\Behat\Manager\CustomDrupalAuthenticationManager');
    $definition->addArgument(new Reference('mink'));
    $definition->addArgument(new Reference('drupal.user_manager'));
    $definition->addArgument(new Reference('drupal.driver_manager'));
    $definition->addArgument('%mink.parameters%');
    $definition->addArgument('%drupal.parameters%');
    $container->setDefinition('drupal.authentication_manager', $definition);
  }

  /**
   * {@inheritdoc}
   */
  public function process(ContainerBuilder $container)
  {
    // Processing services here
  }
}
