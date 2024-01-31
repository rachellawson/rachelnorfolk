Feature: Test Footer Contents
  In order to prove the footer contains the correct items
  As a reader
  I need to view the correct items

  Scenario: Test the ability to find Drupal reference in footer
    Given I am on the homepage
    Then I should see Drupal in the "footer" region

  Scenario: Test that Platform.sh is correctly linked in the footer
    Given I am on the homepage
    Then I should see the link "Platform.sh" in the "footer" region
    When I click "Platform.sh" in the "footer" region
    Then I should be on "https://platform.sh"

