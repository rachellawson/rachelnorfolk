@api
Feature: Author actions
  In order to correctly create content
  As an author
  I want to be able to create articles

  Scenario: Check we have good menus
    Given I am logged in as a user with the "Author" role
    When I am on the homepage
    Then I should see the link "Post" in the "header" region
