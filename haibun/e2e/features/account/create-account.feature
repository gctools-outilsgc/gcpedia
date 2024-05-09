Feature: Account Creation Workflow on Wiki

  Backgrounds: site, form-create-account

  Scenario: Navigating and creating an account on a local Wiki page

  We start by creating a random username and password, and what will become the user page.

    When I have a valid random username <username>
    When I have a valid random password <password>

  Go to the create account page, and fill it in, starting with the gc institution.

    go to the Main webpage
    resize window to 1400x1100
    then click by text "Create account"
    input <username> for Institution email

  We have to pause a bit to get the form to recognize the name and institution have been entered, so it will populate the username field.

    pause for 5s
    Press "Tab"
    Type "c"
    input <password> for Create password input
    input <password> for Confirm password input
    input "test account" for Real name
    Click the checkbox Accept terms
    Click on Create account

  Now the new user has been created, there should be an announcement popup with this information.
  Follow the link.

    In Notification title, see "User page Created"
    Click "here"

  Confirm we're on the new user page.

    URI starts with User page
