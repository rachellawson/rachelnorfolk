<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use Behat\Hook\AfterSuite;
use Behat\Hook\BeforeSuite;
use Behat\Step\Then;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext {

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {
  }

  #[Then('I see a correct OsmAnd link')]
  public function iSeeACorrectOsmandLink(): void
  {
    // Get the secret from config.
    $secret = \Drupal::config('osmand_tracking.settings')->get('secret');

    // Get the hostname.
    $hostname = gethostname();

    // Get the username.
    $username = $this->userManager->getCurrentUser()->getValue('name');

    // Formulate a correct url from hostname, username, and secret config.
    $correct_url = $hostname . '/' . $secret . '/' . $username . '?lat={0}&amp;lon={1}&amp;timestamp={2}&amp;altitude={4}';

    // Find the url on the page and compare.
    // @todo

    throw new PendingException();
  }


}
