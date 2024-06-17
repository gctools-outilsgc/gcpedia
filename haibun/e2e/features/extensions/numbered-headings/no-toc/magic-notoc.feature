
Backgrounds: site, form-login, admin-credentials, login-successful

Feature: Simple Hierarchical Structure

Uses enough headings to generate a table of contents. Each heading level is higher than the next, so they render nested.

    When I have a random address Basic test from Site address
    Go to the Basic test webpage

    Click "Create"
    Click on Wiki editor
    type "__NOTOC__"
    Press Enter
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.2 Subheading 1.2"
    See "2 Main Heading 2"
    See "2.1 Subheading 2.1"

Feature: Skipping Heading Levels

Skips heading levels to test how non-sequential heading levels are handled.

    When I have a random address Skipping test from Site address
    Go to the Skipping test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "==== Subheading 1.2.1.1 ===="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1.1 Subheading 1.1.1"
    See "1.2 Subheading 1.2"
    See "1.2.1.1 Subheading 1.2.1.1"
    See "2 Main Heading 2"

Feature: Mixed Heading Levels
Mixes heading levels to test how the TOC handles a complex hierarchy.

    When I have a random address Mixed test from Site address
    Go to the Mixed test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "=== Subheading 1.1.2 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "== Subheading 1.3 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "=== Subheading 2.1.1 ==="
    Press Enter
    type "== Subheading 2.2 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.1.2 Subheading 1.1.2"
    See "1.2 Subheading 1.2"
    See "1.3 Subheading 1.3"
    See "2 Main Heading 2"
    See "2.1.1 Subheading 2.1.1"
    See "2.2 Subheading 2.2"

Feature: Non-Hierarchical Order
Tests non-hierarchical order to see if the TOC correctly interprets non-sequential headings.

    When I have a random address Non-hierarchical test from Site address
    Go to the Non-hierarchical test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "=== Subheading 2.1.1 ==="
    Press Enter
    type "== Subheading 2.2 =="
    Press Enter
    type "= Main Heading 3 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "2 Main Heading 2"
    See "2.1.1 Subheading 2.1.1"
    See "2.2 Subheading 2.2"
    See "3 Main Heading 3"

Feature: Deep Nesting
Tests deep nesting to see how the TOC handles a deeply nested hierarchy.

    When I have a random address Deep nesting test from Site address
    Go to the Deep nesting test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "==== Subheading 1.1.1.1 ===="
    Press Enter
    type "===== Subheading 1.1.1.1.1 ====="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.1.1.1 Subheading 1.1.1.1"
    See "1.1.1.1.1 Subheading 1.1.1.1.1"
    See "2 Main Heading 2"
    See "2.1 Subheading 2.1"

Feature: Repeated Headings
Tests repeated headings to see how the TOC handles identical headings.

    When I have a random address Repeated headings test from Site address
    Go to the Repeated headings test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1 Subheading 1.1"
    See "2 Main Heading 2"
    See "2.1 Subheading 2.1"
    See "2.1 Subheading 2.1"

Feature: Single Level
Tests single-level headings to see if the TOC handles headings without nesting.

    When I have a random address Single level test from Site address
    Go to the Single level test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "= Main Heading 3 ="
    Press Enter
    type "= Main Heading 4 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "2 Main Heading 2"
    See "3 Main Heading 3"
    See "4 Main Heading 4"

Feature: No Main Heading
Tests heading levels starting from H2 to see if the TOC handles subheadings without a main heading.

    When I have a random address No main heading test from Site address
    Go to the No main heading test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "== Subheading 1 =="
    Press Enter
    type "=== Subheading 1.1 ==="
    Press Enter
    type "== Subheading 2 =="
    Press Enter
    type "=== Subheading 2.1 ==="
    Press Enter
    type "==== Subheading 2.1.1 ===="
    Press Enter
    Click "Save page"

    See "1 Subheading 1"
    See "1.1 Subheading 1.1"
    See "2 Subheading 2"
    See "2.1 Subheading 2.1"
    See "2.1.1 Subheading 2.1.1"

Feature: Simple Hierarchical Structure
Uses enough headings to generate a table of contents. Each heading level is higher than the next, so they render nested.

    When I have a random address Basic test from Site address
    Go to the Basic test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.2 Subheading 1.2"
    See "2 Main Heading 2"
    See "2.1 Subheading 2.1"

Feature: Skipping Heading Levels
Skips heading levels to test how the TOC handles non-sequential heading levels.

    When I have a random address Skipping test from Site address
    Go to the Skipping test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "==== Subheading 1.2.1.1 ===="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1.1 Subheading 1.1.1"
    See "1.2 Subheading 1.2"
    See "1.2.1.1 Subheading 1.2.1.1"
    See "2 Main Heading 2"

Feature: Mixed Heading Levels
Mixes heading levels to test how the TOC handles a complex hierarchy.

    When I have a random address Mixed test from Site address
    Go to the Mixed test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "=== Subheading 1.1.2 ==="
    Press Enter
    type "== Subheading 1.2 =="
    Press Enter
    type "== Subheading 1.3 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "=== Subheading 2.1.1 ==="
    Press Enter
    type "== Subheading 2.2 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.1.2 Subheading 1.1.2"
    See "1.2 Subheading 1.2"
    See "1.3 Subheading 1.3"
    See "2 Main Heading 2"
    See "2.1.1 Subheading 2.1.1"
    See "2.2 Subheading 2.2"

Feature: Non-Hierarchical Order
Tests non-hierarchical order to see if the TOC correctly interprets non-sequential headings.

    When I have a random address Non-hierarchical test from Site address
    Go to the Non-hierarchical test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "=== Subheading 2.1.1 ==="
    Press Enter
    type "== Subheading 2.2 =="
    Press Enter
    type "= Main Heading 3 ="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "2 Main Heading 2"
    See "2.1.1 Subheading 2.1.1"
    See "2.2 Subheading 2.2"
    See "3 Main Heading 3"

Feature: Deep Nesting
Tests deep nesting to see how the TOC handles a deeply nested hierarchy.

    When I have a random address Deep nesting test from Site address
    Go to the Deep nesting test webpage

    Click "Create"
    Click on Wiki editor
    type "__NUMBEREDHEADINGS__"
    Press Enter
    type "= Main Heading 1 ="
    Press Enter
    type "== Subheading 1.1 =="
    Press Enter
    type "=== Subheading 1.1.1 ==="
    Press Enter
    type "==== Subheading 1.1.1.1 ==="
    Press Enter
    type "===== Subheading 1.1.1.1.1 ====="
    Press Enter
    type "= Main Heading 2 ="
    Press Enter
    type "== Subheading 2.1 =="
    Press Enter
    Click "Save page"

    See "1 Main Heading 1"
    See "1.1 Subheading 1.1"
    See "1.1.1 Subheading 1.1.1"
    See "1.1.1.1 Subheading 1.1.1.1"
    See "1.1.1.1.1 Subheading 1.1.1.1.1"
    See "2 Main Heading 2"
    See "2.1 Subheading 2.1"
