#v1.2.2
## 08/21/2016
1.[](#improved)  
    added new gravstrap-images-collage shortcode to render a collage of images from a Grav page

#v1.2.1
## 08/18/2016
1.[](#improved)  
    updated MapShortcode to use Google Maps api key, just adding the optional `api-key` parameter to `g-map` shortcode

#v1.2.0
## 07/19/2016
1.[](#bugfix)  
    shortcodes require a static centralized folder for media files [BC]
    shortcodes now work in pages with children

# v1.1.3
## 07/15/2016
1.[](#improved)  
    * updated to work with shortcode-core 2.3.1 plugin (bashou)

# v1.1.2
## 06/22/2016
1.[](#bugfix)  
    * fixed blueprints.yaml homepage and demo information

# v1.1.1
## 06/21/2016
1.[](#improved)  
    * added mdi icons support

1.[](#bugfix)  
    * fixed assets are not added for common plugins
    * fixed gravstrap-list-item  shortcode does not show the items

# v1.1.0
## 06/12/2016
1.[](#improved)  
    * improved to work with new Grav 1.1

# v1.0.3
## 03/17/2016
1.[](#improved)  
    * parsed shortcodes assets and added them by type to Grav
    * added new Google map shortcode

# v1.0.2
## 03/03/2016
1.[](#bugfix)  
    * button with link property now goes to linked url

# v1.0.1
## 03/02/2016
1.[](#improved)  
    * added button_url property which adds the link attribute to button

2.[](#bugfix)    
    * added missing assets configuration to FooterTwoShortcode

# v1.0.0
## 03/01/2016
1.[](#improved)    
    * Improved ListShortcode and removed ListItemShortcode
    * Added g- alias to all the shortcodes

2. [](#bugfix)
    * Fixed navbar cover heading in one page web sites

# v1.0.0-rc.3
## 02/27/2016
1. [](#bugfix)
    * fixed attributes broken on link shortcode

2.[](#new)
    * Added new gravstrap-list shortcode to handle a generic list
    * Added new gravstrap-item shortcode to handle a generic html item

# v1.0.0-rc.2
## 02/24/2016
1. [](#bugfix)
    * extended FooterTwoShortcode from GravstrapShortcode instead of FooterOneShortcode because this could cause an error

# v1.0.0-rc.1
## 02/23/2016
1. [](#bugfix)
    * Added id property to navbar required to open the "hamburger" menu
    * Fixed navbar dropdown menu rendering for small devices

2.[](#new)
    * Added optional highdensity-menu class useful to handle the automatic menu for webs ites that have several pages

# v1.0.0-rc
## 02/18/2016

1. [](#new)
    * Refactored shortcodes according to shortcode core plugin
    * All shortcodes are now prefixed by gravstrap token to avoid conflicts with other shortcodes [ BC ]
    * Delegated shortcode registration to core ShortcodeManager
    * Moved ParseAttributes function to new Twig extension

# v1.0.0-beta.2
## 02/10/2016

1. [](#new)
    * updated to work with new shortcode core plugin

2. [](#bugfix)
    * sections was not properly cached


# v1.0.0-beta.1
## 02/09/2016

1. [](#bugfix)
    * assets are now added by type

2. [](#new)
    * added attributes parameter to sections


# v1.0.0-beta
## 02/09/2016

1. [](#new)
    * Redesigned plugin to use shortcodes. This release is not compatible with previous 0.9.x version.

# v0.9.7
## 12/14/2015

1. [](#bugfix)
    * Gravstrap can read configuration from modules

# v0.9.6
## 12/13/2015

1. [](#bugfix)
    * Removed wrong dependency (which was added for a test)

# v0.9.5
## 12/13/2015

1. [](#improved)
    * Added plugin dependencies

# v0.9.4
## 12/11/2015

1. [](#bugfix)
    * Fixed navbar dropdown link, removing the gray background and fixed link color

# v0.9.3
## 12/11/2015

1. [](#bugfix)
    * Used module folder name as scrolling id anchor for single page website navbar menu

# v0.9.2
## 12/09/2015

1. [](#bugfix)
    * Fixed active page is not highlighted in navbar

# v0.9.1
## 12/09/2015

1. [](#new)
    * Added the onepage property to navbar menu, to easily handle a onepage website with scrolling effect

2. [](#improved)
    * Improved to handle images saved into module's folder
    * Changed navbar links colors to grayscale
    * Added label to progress bar component

# v0.9.0
## 11/26/2015

1. [](#new)
    * Plugin started
