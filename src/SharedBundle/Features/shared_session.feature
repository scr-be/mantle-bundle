Feature: Handle context-based login

    Scenario: Sign in and log out from Status
        Given I am on "/status/dashboard"
        And I follow "Sign In" with context
        And I should see "Scribe Status"
        When I fill in "_username" with "flast@scribenet.com"
        And I fill in "_password" with "n,XYQu9q"
        And I press "Sign In"
        Then I should be on "/status/dashboard"
        When I follow "Sign Out"
        Then I should be on "/status/dashboard"

    Scenario: Sign in and log out from Learning
        Given I am on "/wfdw/docs/index"
        And I follow "Sign In" with context
        # this will change when the docs are expanded to include learning
        And I should see "Scribe Digital Hub"
        When I fill in "_username" with "flast@scribenet.com"
        And I fill in "_password" with "n,XYQu9q"
        And I press "Sign In"
        Then I should be on "/wfdw/docs/index"
        When I follow "Sign Out"
        Then I should be on "/wfdw/docs/index"

    Scenario: Sign in and log out from WFDW Blog
        Given I am on "/blog"
        And I follow "Sign In" with context
        And I should see "Scribe WFDW Blog"
        When I fill in "_username" with "flast@scribenet.com"
        And I fill in "_password" with "n,XYQu9q"
        And I press "Sign In"
        Then I should be on "/blog/"
        When I follow "Sign Out"
        Then I should be on "/blog"
