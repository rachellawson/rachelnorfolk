@api
Feature: testing we have api function running right

  Scenario: Create a node
    Given I am logged in as a user with the "administer nodes" permission
    When I am viewing an "article" content with the title "My article"
    Then I should see the heading "My article"

  Scenario: Run cron
    Given I am logged in as a user with the "Administrator" role
    When I run cron
    And am on "admin/reports/dblog"
    Then I should see the link "Cron run completed"

  Scenario: Create a term
    Given I am logged in as a user with the "Administrator" role
    When I am viewing a "tags" term with the name "My tag"
    Then I should see the heading "My tag"

  Scenario: Create many terms
    Given "tags" terms:
      | name    | description    |
      | Tag one | the first one  |
      | Tag two | the second one |
    And I am logged in as a user with the "Administrator" role
    When I go to "admin/structure/taxonomy/manage/tags/overview"
    Then I should see "Tag one"
    And I should see "Tag two"
