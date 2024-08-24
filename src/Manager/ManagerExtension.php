<?php

namespace HelloWorldDevs\Behat\Manager;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ManagerExtension implements ExtensionInterface
{
  public function getConfigKey()
  {
    return 'manager_extension';
  }

  public function initialize(ExtensionManager $extensionManager) {}

  public function configure(ArrayNodeDefinition $builder) {}

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

  public function process(ContainerBuilder $container) {}
}
