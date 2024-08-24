<?php

namespace HelloWorldDevs\Behat\Manager;

use Drupal\DrupalExtension\Manager\DrupalAuthenticationManager;

class CustomDrupalAuthenticationManager extends DrupalAuthenticationManager
{

  /**
   * {@inheritdoc}
   */
  public function logIn(\stdClass $user)
  {
    // Ensure we aren't already logged in.
    $this->fastLogout();

    $this->getSession()->visit($this->locatePath($this->getDrupalText('login_url')));

    // Wait for the page to fully load before interacting with it
    $this->getSession()->wait(5000, 'document.readyState === "complete"');

    $element = $this->getSession()->getPage();
    $element->fillField($this->getDrupalText('username_field'), $user->name);
    $element->fillField($this->getDrupalText('password_field'), $user->pass);
    $submit = $element->findButton($this->getDrupalText('log_in'));
    if (empty($submit)) {
      throw new \Exception(sprintf("No submit button at %s", $this->getSession()->getCurrentUrl()));
    }

    // Log in.
    $submit->click();

    // Wait for the page to fully load after clicking the submit button
    $this->getSession()->wait(5000, 'document.readyState === "complete"');

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
