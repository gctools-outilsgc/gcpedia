
Backgrounds: site, form-login, admin-credentials, login-successful

Tests for when there are fewer than four heading levels, so Mediawiki does not generate a TOC.

Feature: Single h1 heading

One top level heading with no toc.

    When I have a random address sample from Site address
    Go to the sample webpage

    Click "Create"
    Click on Wiki editor
    type "__TOC__"
    Press Enter
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"

Feature: Multiple h1 headings

One top level heading with no toc.

    When I have a random address sample from Site address
    Go to the sample webpage

    Click "Create"
    Click on Wiki editor
    type "__TOC__"
    Press Enter
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "= Main Heading 2 ="
    Click "Save page"

    See "1 Main Heading 1"
    See "2 Main Heading 2"