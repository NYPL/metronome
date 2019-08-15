# AI: Icons

This is the icon logic file that contains the flags for all of the permutations of the icons you see below. Please see `source/_data/icon.json` to see and understand the flags that this component accepts.

Icons will accept the following classes for setting size: `.small`, `.medium`, `.large`, and `.xlarge`. For some icons we give recommendations in the permutation files as to _size_. Decorative icons, such as `Book`, `Computer`, `Play`, `CD`, `Movie`, and `Booklist`, typically are displayed as `.large` or `.xlarge`, although there maybe be exceptions. These icons will also accept the `.purple` icon color while other icons will not.

Some icons have been designed to optimized their visuals in small situations. If you are passing a `.small` class to the `arrow-down` or `check` icons, we recommend using their `-small` variant instead, which are slightly thicker and appear better at small sizes.

- Brand Identity
- Consistent language of symbols for common actions and items

Accessibility & Functional Requirements
Decorative icons
Is implemented as background styles.

Meaningful icons
- Is implemented as <img> with alt attribute.
- When image is meaningful <alt> attribute is descriptive
- Whem image is decoratie, `alt=””`