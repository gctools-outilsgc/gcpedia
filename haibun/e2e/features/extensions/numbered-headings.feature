
Feature: Numbered lists

Backgrounds: site, form-login, admin-credentials, login-successful

When I have a valid random username <pagename>
Concat "http://wiki.local/" and <pagename> as Random
Go to the Random webpage

Click "Create"
Click on Wiki editor
type "__NUMBEREDHEADINGS__"
type "# H1"
Click "Save page"
See text "1. H1"
