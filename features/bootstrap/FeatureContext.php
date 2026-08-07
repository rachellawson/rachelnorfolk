<?php

use Drupal\Core\Url;
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
    if (empty($secret)) {
      throw new Exception('There does not appear to be a secret defined.');
    }

    // Get the hostname.
    $url_options = [
      'absolute' => TRUE,
    ];
    $host = Url::fromRoute('<front>', [], $url_options)->toString();

    // Get the user.
    $uid = $this->userManager->getCurrentUser()->getId();

    // Formulate a correct url from hostname, username, and secret config.
    $correct_url = $host . $secret . '/' . $uid . '?lat={0}&lon={1}&timestamp={2}&altitude={4}';

    // Find the url on the page and compare.
    $observed_url = $this->getSession()->getPage()->findById('osmlink')->getText();
    if (empty($observed_url)) {
      throw new Exception('There does not appear to be an OsmAnd link on the page.');
    }

    // Compare them.
    if ($observed_url !== $correct_url) {
      throw new Exception('The observed OsmLink does not look like the expected one.');
    }

  }

}
