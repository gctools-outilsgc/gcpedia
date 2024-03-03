
Backgrounds: site, form-login, admin-credentials, login-successful

    When I have a valid random username <filebase>
    When I have a valid random username <content>
    Concat <filebase> and ".txt" as Random file
    Create 10M file at /tmp/foo.txt with <content>
    Concat "File:" and Random file as Wiki file 

    Go to the File upload webpage
    Upload file /tmp/foo.txt using Choose file
    Input Random file for Destination filename
    Click on Upload file button

#    In Download link, see Random file
    Change links matching Download link to download
    Register download to /tmp/verify-foo.txt
    Click on Download link
    /tmp/foo.txt is the same as /tmp/verify-foo.txt

