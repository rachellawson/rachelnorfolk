@api
Feature: Author actions
  In order to correctly create content
  As an author
  I want to be able to create articles and basic pages but not other things, like Mary Facts

  Scenario: Check we have correct content types
    Given I am logged in as a user with the "Administrator" role
    When I visit '/node/add'
    Then I should see "Article"
    And I should see "Basic page"
    And I should not see "Mary fact"
