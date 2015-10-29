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

You can find the full declatarion for each available Bootstrap element into the `elements` folder, you can use to test it.

# Installation

Installing the Gravstrap plugin can be done only manually at the moment, because the project is just started and it is not yet available through the GPM system. 

## Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `gravstrap`. You can find these files either on [GitHub](https://github.com/giansi/grav-plugin-gravstrap).

## Contributing

Feel free to fork this project and help the development! You are welcome!