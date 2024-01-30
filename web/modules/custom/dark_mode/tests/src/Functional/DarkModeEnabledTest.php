<?php declare(strict_types = 1);

namespace Drupal\Tests\dark_mode\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Check that we are actually putting the css on the page.
 *
 * @group dark_mode
 */
final class DarkModeEnabledTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'olivero';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['dark_mode'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Set up the test here.
  }

  /**
   * Test callback.
   */
  public function testLibraryLoaded(): void {
    $this->drupalGet('/');
    $this->assertSession()->statusCodeEquals(200);

    // Should contain the dark mode css but not that for grey pride.
    $this->assertSession()->responseContains('dark_mode/css/dark-mode.css');
    $this->assertSession()->responseNotContains('dark_mode/css/grey-pride.css');
  }

}
