Feature: Edit save source editor page

Backgrounds: site, form-login, admin-credentials, login-successful

When I have a valid random username <pagename>
Concat "http://wiki.local/" and <pagename> as Random source

Go to the Random source webpage

Click "Create source"
Click on Wiki editor
Type "Test text"
Click "Save page"
Pause for 2s
See "The page has been created."


