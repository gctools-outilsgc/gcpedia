
Feature: Multilang

Backgrounds: site, form-login, admin-credentials, login-successful

When I have a valid random username <pagename>
Concat "http://wiki.local/" and <pagename> as Random
Go to the Random webpage

Click "Create"
Click on Wiki editor
type "<multilang>"
Press Enter
type "@en|English text"
Press Enter
type "@fr|Texte français"
Press Enter
type "</multilang>"
pause for 1s
Press Escape
Click "Save Page"
see "English text"
Click on Language toggle
pause for 1s
See "Texte français"
