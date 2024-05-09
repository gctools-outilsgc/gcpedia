
Set Language toggle to //*[@id="header-lang-toggle"]

Set Site address to "http://wiki.local/"

Concat Site address and "Special:UserLogin" as Log in
Concat Site address and "Special:UserLogin?uselang=en-ca" as English Log in
Concat Site address and "Special:UserLogin?uselang=fr" as French Log in
Concat Site address and "Main_Page" as Main
Concat Site address and "Main_Page?uselang=en-ca" as English Main
Concat Site address and "Main_Page?uselang=fr" as French Main
Concat Site address and "Special:Upload" as File upload

Set Login input to //*[@id="wpName1"]
Set Password input to //*[@id="wpPassword1"]
Set Log in button to //*[@id="wpLoginAttempt"]

Set Destination filename to //*[@id="wpDestFile"]
Set Choose file to //*[@id="wpUploadFile"]
Set Upload file button to //*[@id="mw-upload-form"]/span/input
Set Download link to ".dangerousLink > a"

# wiki editor
Set Create to //*[@id="ca-ve-edit"]/a
Set Create source to //*[@id="ca-edit"]/a
Set Wiki editor to //*[@id="wpTextbox1"]
Set Save page to //*[@id="wpSave"]

# preferences

Set Preferences to //*[@id="pt-preferences"]/a
Set Languages label to //*[@id="ooui-4"]
Set Save preferences to //*[@id="prefcontrol"]/button
