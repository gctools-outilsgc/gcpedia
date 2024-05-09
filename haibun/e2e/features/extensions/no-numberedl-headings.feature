
Feature: No numbered lists

Backgrounds: site, form-login, admin-credentials, login-successful

When I have a valid random username <pagename>
Concat "http://wiki.local/" and <pagename> as Random
Go to the Random webpage

Click "Create"
Click on Wiki editor
type "__NONUMBEREDHEADINGS__"
type "# H1"
type "# H2"
Click "Save Page"