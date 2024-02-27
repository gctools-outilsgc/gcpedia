Feature: Account Creation Page Accessibility

  Scenario: Verify the create account page is accessible

    go to the "http://wiki.local/Main_Page" webpage
    then click by text "Create account"

    page is accessible accepting serious 0 and moderate 0