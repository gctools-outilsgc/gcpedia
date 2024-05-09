Feature: Multilang

Backgrounds: site, form-login, admin-credentials, login-successful, preferences-english

When I have a valid random username <pagename>
Concat "http://wiki.local/" and <pagename> as Random
Concat Random and "?uselang=en-ca" as English Random
Go to the English Random webpage

Click the link Create source
Click the link Wiki editor
type "<multilang>"
Press Enter
type "@en|English text"
Press Enter
type "@fr|Texte français"
Press Enter
type "</multilang>"
Click the button Save page
see "English text"
Click on Language toggle
pause for 1s
See "Texte français"