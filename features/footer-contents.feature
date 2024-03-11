Feature: Test Footer Contents
  In order to prove the footer contains the correct items
  As a reader
  I need to view the correct items

  Scenario: Test the ability to find Drupal reference in footer
    Given I am on the homepage
    Then I should see Drupal in the "footer" region

