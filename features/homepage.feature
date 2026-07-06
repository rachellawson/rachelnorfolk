Feature: Test Homepage Contents
  In order to prove the homepage contains the correct items
  As a reader
  I need to view the correct items

  Scenario: Check that the blog view is displayed
    Given I am on the homepage
    Then I should see the heading "Latest thoughts, if any, of Rachel Lawson..." in the "content_above" region

  Scenario: Check I have my links in the sidebar
    Given I am on the homepage
    Then I should see the link "Syndicate" in the "socialbar" region
    And I should see the link "Mastodon" in the "socialbar" region
    And I should see the link "Bluesky" in the "socialbar" region
    And I should see the link "LinkedIn" in the "socialbar" region
    And I should see the link "GitHub" in the "socialbar" region
    And I should not see the link "Twitter" in the "socialbar" region
