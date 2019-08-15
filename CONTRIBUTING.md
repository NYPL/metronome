# Contributing to this Documentation

In order to contribute to this documentation you must first have a Github account which you can procure [here](https://github.com). If you are a core team member and would like contribution access, please contact [@helenvholmes](https://github.com/helenvholmes) or [@jackkim9](https://github.com/jackkim9).

## Table of Contents
1. [Where Our Documentation Lives](#where-our-documentation-lives)
2. [Editing Existing Documentation](#editing-existing-documentation)
3. [Creating New Documentation](#creating-new-documentation)
4. [Adding References to Figma Frames](#adding-references-to-figma-frames)
5. [Learning Markdown](#learning-markdown)
6. [Programs for Authoring Markdown](#programs-for-authoring-markdown)
7. [Contributing for Developers](#contributing-for-developers)

## Where Our Documentation Lives
Our documentation is hosted on Github Pages at [nypl.github.io/nypl-design-system-docs](https://nypl.github.io/nypl-design-system-docs/#/), which is linked to at the top level of this repo at [github.com/NYPL/nypl-design-system-docs](https://github.com/NYPL/nypl-design-system-docs). This site is built using a library called [Docsify](https://docsify.js.org), which takes a collection of markdown files and compiles them into a static site. We host this static site on Github Pages, which is free. Docsify is also free. We use Github's built in tools to edit these markdown files which then are automatically compiled, building a new version of the site each time we hit save on a file.

## Editing Existing Documentation
There are two ways to navigating to the documentation you would like to update. The first is by navigating to the file using Github's file directory, the top level of which can be found [here](https://github.com/NYPL/nypl-design-system-docs). The second is by navigating to the desired page on the documentation site itself [here](https://nypl.github.io/nypl-design-system-docs/#/) and clicking the "Edit in Github" text link in the upper right hand corner. This will navigate you to the markdown file in Github.

Regardless of how you navigate to it, the following steps are how you edit and file and contribute it back to the website:

1. Click the pencil icon in the upper right hand corner. Hovering over it should give you the alt text "Edit this file". It is nestled between a small computer icon and a small trash can icon.
2. This will take you to the edit mode. Make your desired changes in the file. If you are unfamiliar with markdown we have two sections that may be relevant to you: [Learning Markdown](#learning-markdown) | [Programs for Authoring Markdown](#programs-for-authoring-markdown)
3. When you have completed authoring your changes, scroll to the bottom of the page. Under the subheader "Commit changes", add a meaningful commit message for the changes you have made. An example of a good commit is this one from Ellen:

    `Adds subfield categories to 3. AT-001: Page Title`

    An example of a poor commit message is this one:

    `Updates CONTRIBUTING.md`

4. After authoring a meaningful commit message, hit the green button labeled "Commit changes".
5. Navigate to the website and the subpage that you have edited. See your new changes by doing a hard refresh on the page (`Shift` + `Cmd` + `R` for Macs, `Shift` + `Ctrl` + `R` for Windows and Linux machines).

## Creating New Documentation
Creating new documentation files is slightly more involved. Should you have issues creating a file where you would like it to live, please reach out to [@helenvholmes](https://github.com/helenvholmes).

1. First determine whether you are writing the documentation for a component or a template/page. Components include `atoms`, `molecules`, and `organisms` within our design library. A candidate for a template would be `community showcase`. Depending upon your answer to this question, use `COMPONENT_TEMPLATE.md` or `TEMPLATE_TEMPLATE.md` respectively.
2. Once you have determined which template file you will need, copy the contents of that file to a local file on your computer. There, fill out the necessary documentation included within the template file. See [Programs for Authoring Markdown](#programs-for-authoring-markdown).
3. Once you feel ready for the content to go live, navigate to the folder where you would like your new page to live within Github. For example, if you are working on the colors atom, you would navigate like so:

    [Github repo top level](https://github.com/NYPL/nypl-design-system-docs) > [00-atoms folder](https://github.com/NYPL/nypl-design-system-docs/tree/master/00-atoms) > [colors folder](https://github.com/NYPL/nypl-design-system-docs/tree/master/00-atoms/colors)

    Within this folder, hit the button "Create new file". Give it a sensible name. This means:
      - No spaces
      - No special characters (with the exception of underscores _ or dashes -)
      - No uppercase characters except for the A, M, O, and T representing atoms, molecules, organisms, and templates
    Afterward copy and paste your written documentation from the file on your computer into the text box within Github.

4. Once you have added your documentation to the text frame, scroll to the button of the page and author a meaningful commit message. Afterwards, hit the green button labeled "Commit changes".
5. While you have added a new page and that page now exists on the website, there is currently no way to navigate to it. To get to the page on the website we need to add a reference to the file to the sidebar. Navigate to the [top level](https://github.com/NYPL/nypl-design-system-docs) of our repository and navigate inside `_sidebar.md`, hitting the "Edit" pencil icon.
6. Scroll to the relevant section for your new file. Building on the example above, I would navigate to the section of `_sidebar.md` that housed `00-atoms > colors`.
7. Add a new line to this file where you would like the link to your file to go. Add a title for the link and the link to the markdown file. The template for this is like so:

    `* [Template name](link/to/template.md)`

    For our example above, we would do:

    `* [Our color file name](00-atoms/colors/our-color-file-name.md)`

    To properly nest our sidebar we use whitespace. _This means that the number of spaces you use is important._ For a top-level link, I would add no spaces to the left of the asterik. For a first level sublink, I would use two, for a second level sublink, I would use four, increasing by two for each level of nesting.

    ```
    * Level one
      * Level two
        * Level three
    ```
8. Scroll to the bottom of the page and author a meaningful commit, then hitting the green button that says "Commit changes."
9. Navigate to the website. See your change to the sidebar by doing a hard refresh on the page (`Shift` + `Cmd` + `R` for Macs, `Shift` + `Ctrl` + `R` for Windows and Linux machines). Navigate to the link to ensure you have hooked everything up properly.

## Adding References to Figma Frames
Most documentation files require a reference to the relevant Figma design(s) to be considered complete. The following is how you add a Figma embed to your markdown file:

1. Navigate to the relevant Figma file.
2. Click on the Figma frame you would like to reference. The name of the frame should appear in blue when you have done this properly, and the frame should have a light blue border around it.
3. In the upper right hand corner of Figma, click the "Share" button.
4. At the bottom of the modal, click the text link that says "Get embed code".
5. Click the button that says "Copy".
6. Paste the code in whatever markdown file needs to have a reference to this Figma file.

## Learning Markdown
Our documentation is written using a lightweight markup language called [Markdown](https://en.wikipedia.org/wiki/Markdown). The language uses different kinds of punctuation marks to tell the computer compiler how to format our files without us as authors having to learn and use HTML proper.

In order to learn the syntax necessary for this project we recommend reviewing [Github's guide to Mastering Markdown](https://guides.github.com/features/mastering-markdown/). Below is a cheatsheet of commonly needed formatting options:

```
# h1
## h2
### H3 
**bold**
_italic_
```

## Programs for Authoring Markdown
You may find that authoring markdown in Github becomes tiring or difficult to read. There are a few options if you'd like a different application for authoring markdown.

* [Dillinger](https://dillinger.io): Dillinger is a markdown authoring tool that works in your browser and doesn't require an install, making it good for both Mac and Windows users. It also allows you to see markdown on the left and your compiled HTML on the right.
* [Bear App](https://bear.app/): If you'd like a native tool, Bear App is free for download on Mac.
* [Typora](https://typora.io/): Typora is a native tool for Windows.

This list is not exhaustive, and many other free tools exist—feel free to use one of these or find a different one that you like the look and ease of use of the most.

## Retiring Documentation
At this point in our process, pre V1, we are not super concerned with retiring documentation yet. However, this item is in our backlog. Please reference [the issue](https://github.com/NYPL/nypl-design-system-docs/issues/5) for updates on this topic.

## Contributing for Developers
If you'd like to contribute to this project we label starter issues with [good first issue](https://github.com/NYPL/nypl-design-system-docs/labels/good%20first%20issue). We label more involved issues with [help wanted](https://github.com/NYPL/nypl-design-system-docs/labels/help%20wanted).

Another option if you'd like to contribute is to reference our [milestones](https://github.com/NYPL/nypl-design-system-docs/milestones), which track higher-level efforts for this project, and to see any of the milestones fit in with a skillset you may have. If one does, feel free to reach out to [@helenvholmes](https://github.com/helenvholmes).