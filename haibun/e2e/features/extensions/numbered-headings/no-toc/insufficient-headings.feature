
Backgrounds: site, form-login, admin-credentials, login-successful

No toc or numbered headings are generated when there are less than 4 headings.

Feature: Simple Hierarchical Structure

Test with one h1.

    When I have a random address sample from Site address
    Go to the sample webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    Click "Save page"

    See "Main Heading 1"
    Don't see "1 Main Heading 1"

Feature: Simple Hierarchical Structure

Test with an h1 and h2.

    When I have a random address sample from Site address
    Go to the sample webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Main Heading 2 =="
    Press Enter
    Click "Save page"

    See "Main Heading 1"
    Don't see "1 Main Heading 1"
    See "Main Heading 2"
    Don't see "2 Main Heading 2"
