Feature: Account Creation Workflow on Wiki

  Backgrounds: account

  Scenario: Navigating and creating an account on a local Wiki page

  We start by creating a random username and password, and what will become the user page.

    When I have a valid random username <username>
    When I have a valid random password <password>
    concat "User:" and <username> as User page

  Go to the create account page, and fill it in, starting with the gc institution.

    go to the "http://wiki.local/Main_Page" webpage
    resize window to 1400x1100
    then click by text "Create account"
    input <username> for Institution email

  We have to wiggle a bit to get the form to recognize the name and institution have been entered, so it populates the username field.

    pause for 1s
    blur Institution email
    Press "Tab"
    Type "c"
    input <password> for Password
    input <password> for Confirm password
    input "test account" for Real name
    Click the checkbox Accept terms
    Click on Create account

  Now the new user has been created, there should be an announcement popup with this information.
  Follow the link.

    In Notification title, see "User page Created"
    Click "here"

  Confirm we're on the new user page.

    URI case insensitively matches User page
