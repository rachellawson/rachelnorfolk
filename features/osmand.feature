@api
Feature: Test OsmAnd is appearing in right places
  In order to receive OsmAnd location
  As an Author
  I need to be able to see the correct url to enter into OsmAnd unique to my account

  Scenario: Viewing the url to enter into OsmAnd
    Given I am logged in as a user with the "Author" role
    When I visit '/user'
    And I click 'OsmAnd Link'
    Then I should see the text 'Your unique link to enter into OsmAnd is'
    And I see a correct OsmAnd link


