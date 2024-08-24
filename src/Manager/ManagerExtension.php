<?php

namespace HelloWorldDevs\Behat\Manager;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

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
    $container->setDefinition('manager_extension.authentication_manager', $definition);
  }

  public function process(ContainerBuilder $container) {}
}
