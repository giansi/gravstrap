# Gravstrap Plugin

`Gravstrap` is a [Grav](http://github.com/getgrav/grav) plugin that gives you the ability to use Bootstrap elements in the Grav way. Each Bootstrap element can be defined both at site level and / or at page level. When you define the same element, the page overrides the site element.

Each element is defined by a `yaml configuration`. To add a carousel to your template, you just need configure it in the page header as follows:

    gravstrap:
        carousel:        
            # Add as many carousels as you need
            carousel1:
                id: bscarousel
                previous_label: Previous
                next_label: Next
                items:
                    0:
                        image: image1.jpg
                        caption: an awesome image
                    1:
                        image: image2.jpg
                        caption: another awesome image

The `gravstrap` node, defined at the root, gathers the Bootstrap elements. Next, you must add a child node under it, to declare the element type you want to render, in our example it is a `carousel`. Under this node you can define as many elements as you need.

To use the elements in your template, you just call the `{{ gravstrap.carousel1 }}` instruction, to have your carousel rendered. If you declare another carousel, called  for example `carousel2`

    gravstrap:
        carousel:        
            # Add as many carousels as you need
            carousel1:
                id: bscarousel1
                [...]
            carousel2:
                id: bscarousel2
                [...]

you just render it in your template as follows: `{{ gravstrap.carousel2 }}`.

## Sections

Some `Bootstrap controls` can contain an HTML content, for example the `Jumbotron`, the `Thumbnails` or the `Tabs` controls. In this case it would be nice to add that content using Markdown. It is not possible to add a full markdown content in the header section, because some markdown characters are not allowed here.

To solve this problem, you can add a markdown file which will contain one or more sections where you will define the content to render.

This file is declared in the `header` section, using `from_file` keyword, as follows:

    gravstrap:
        tabs:
            tab1:
                from_file: tabs.markdown

The `tabs.markdown` file obviously lives under the page where it is rendered and it is defined as follows:

    [SECTION Gpm]

    ### GPM Installation (_Preferred_)

    The simplest way to install this theme is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (_also called the command line_).  From the root of your Grav install type:

        bin/gpm install tessellate

This will install this theme into your `/user/themes` directory within Grav. Its files can be found under `/your/site/grav/user/themes/tessellate`.

    [/SECTION]

You can find the full declaration for each available Bootstrap element into the `elements` folder, you can use to test it. The example files are placed under the elements/files folder.

# Installation

Installing the Gravstrap plugin can be done only manually at the moment, because the project is just started and it is not yet available through the GPM system. 

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `gravstrap`. You can find these files either on [GitHub](https://github.com/giansi/grav-plugin-gravstrap).

## Contributing

Feel free to fork this project and help the development! You are welcome!