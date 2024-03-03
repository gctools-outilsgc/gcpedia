
Set Language toggle to //*[@id="header-lang-toggle"]

Set Site address to "http://wiki.local/"

Concat Site address and "Special:UserLogin" as Log in
Concat Site address and "Main_Page" as Main
Concat Site address and Special:Upload as File upload

Set Login input to //*[@id="wpName1"]
Set Password input to //*[@id="wpPassword1"]
Set Log in button to //*[@id="wpLoginAttempt"]

Set Wiki editor to //*[@id="wpTextbox1"]

Set Destination filename to //*[@id="wpDestFile"]
Set Choose file to //*[@id="wpUploadFile"]
Set Upload file button to //*[@id="mw-upload-form"]/span/input
Set Download link to ".dangerousLink > a"
