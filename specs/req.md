# Wordpress Plugin Requirement Specs

Create a wordpress plugin. 

Create a php code in modular structure codebase.


Design plugin to be a component-base for use in wordpress via a *shortcode*

## Functional Requirements

- UI can input a  assets:

    1. Stock name
    2. buy amount
    3. stock category
    4. Date Buy

Then save data into a [wordpress database](database.md)

- Dashboard UI is a Main Page that combine a user assets:
    1. total assets
    2. Growth/Loss Wealth (use graph)
    3. List categories
    4. Categories Ranking