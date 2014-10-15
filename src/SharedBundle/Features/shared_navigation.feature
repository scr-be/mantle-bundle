Feature: The navigation and routing of shared header and footer should give users access to various parts of the site.

  Scenario: Navigate to Accounts
    Given I am on "/wfdw/docs/index"
    And I follow "Accounts"
    Then the url should match ".*/security/.*"

  Scenario: Navigate to Login
    Given I am on "/wfdw/docs/index"
    And I follow "Sign In"
    Then the url should match ".*/security/.*"

  Scenario: Navigate to Documentation from Documentation
    Given I am on "/wfdw/docs/index"
    And I follow "Documentation"
    Then the url should match ".*/wfdw/docs/index"

  Scenario: Navigate to Status
    Given I am on "/wfdw/docs/index"
    And I follow "Status"
    Then the url should match ".*/status/.*"

  Scenario: Navigate to WFDW
    Given I am on "/wfdw/docs/index"
    And I follow "Blog/Book"
    Then the url should match ".*/blog/.*"
