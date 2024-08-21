<?php

namespace HelloWorldDevs\AtdoveBehatAuthManager\Manager;

use Behat\Mink\Mink;
use Drupal\Driver\AuthenticationDriverInterface;
use Drupal\DrupalDriverManagerInterface;

class AtdoveBehatAuthenticationManager extends DrupalAuthenticationManager
{

  public function __construct(Mink $mink, DrupalUserManagerInterface $drupalUserManager, DrupalDriverManagerInterface $driverManager, array $minkParameters, array $drupalParameters)
  {
    $this->setMink($mink);
    $this->userManager = $drupalUserManager;
    $this->driverManager = $driverManager;
    $this->setMinkParameters($minkParameters);
    $this->setDrupalParameters($drupalParameters);
  }

  // Your custom logic, like clicking the "Email Login" button
  public function logIn(\stdClass $user)
  {
    // Ensure we aren't already logged in.
    $this->fastLogout();

    $this->getSession()->visit($this->locatePath($this->getDrupalText('login_url')));
    $element = $this->getSession()->getPage();

    // Check if "Email Login" button is present and click it
    $emailLoginButton = $element->findButton('Email Login');
    if ($emailLoginButton) {
      $emailLoginButton->click();
    }

    $element->fillField($this->getDrupalText('username_field'), $user->name);
    $element->fillField($this->getDrupalText('password_field'), $user->pass);
    $submit = $element->findButton($this->getDrupalText('log_in'));
    if (empty($submit)) {
      throw new \Exception(sprintf("No submit button at %s", $this->getSession()->getCurrentUrl()));
    }

    // Log in.
    $submit->click();

    if (!$this->loggedIn()) {
      if (isset($user->role)) {
        throw new \Exception(sprintf("Unable to determine if logged in because 'log_out' link cannot be found for user '%s' with role '%s'", $user->name, $user->role));
      } else {
        throw new \Exception(sprintf("Unable to determine if logged in because 'log_out' link cannot be found for user '%s'", $user->name));
      }
    }

    $this->userManager->setCurrentUser($user);

    // Log the user in on the backend if possible.
    if ($this->driverManager->getDriver() instanceof AuthenticationDriverInterface) {
      $this->driverManager->getDriver()->login($user);
    }
  }
}
