Feature: Language toggle

Backgrounds: site

Scenario: Switch from default English to French

    Go to the Main webpage
    In Language toggle, see "Français"
    Click on Language toggle
    In Language toggle, see "English"

Scenario: Switch back to Français
  Go to the Main webpage
    In Language toggle, see "English"
    Click on Language toggle
    In Language toggle, see "Français"