# Install

`npm i docsify-cli -g`

`docsify serve ./nypl-design-system-docs`

## Blue Skies
The follow is a list of things we'd like this documentation site to accomplish or be capable of.

- Site should be searchable
- Site should be editable
- Site should have a table of all of the components with their statuses (in-progress, in-review, complete), and the implementation libraries' statuses (Twig template, React component, ERB template)
- Site should have authorship data, last revision date(s) on files, and descriptions of changes made (such as a git commit)
- Site should have roles so that certain users can lock components and their documentation to prevent edits unless author has a certain role
- In-progress components should have a working draft that is still visible on the site
- We should be able to see everywhere a component is used—for example, ResearchNow has a section that pulls in dynamically all of the components it is using for QA to be able to see all of that information in one place
- Site should have an intro page and a Getting Started Guide
- Components should display the relationships of where they are used and link back to their lower-level functional requirements (e.g., "Event Status Bar" uses "Button", link to the button component to see its requirements)
- Components should have: link to Figma instance for designers, IA (functional specs and accessibility), look & feel, their status, a built and interactive display of the component in-action, and the numbered documentation that Ellen created listing functional requirements.
- We should be able to number the components on the page in our documentation site to write documentation for them. This should automatically add the number to that component in Figma.

Ideation/Product >> UX/Prototype >> Design Technology (templates, React components) >> Version Update >> Committing back to the library

## Open Issues
- How do we handle JavaScript?