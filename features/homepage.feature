Feature: Test Homepage Contents
  In order to prove the homepage contains the correct items
  As a reader
  I need to view the correct items

  Scenario: Check that the blog view is displayed
    Given I am on the homepage
    Then I should see the heading "Latest thoughts, if any, of Rachel Lawson..." in the "content" region
