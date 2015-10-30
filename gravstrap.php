<?php
/**
 * This file is part of the Gravstrap plugin and it is distributed
 * under the MIT License. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) Giansimon Diblas <info@diblas.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://diblas.net
 *
 * @license    MIT License
 *
 */

namespace Grav\Plugin;

use \Grav\Common\Plugin;

class GravstrapPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        $this->enable([
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Set needed variables to display breadcrumbs.
     */
    public function onTwigSiteVariables()
    {
        $this->grav['assets']->add('plugin://gravstrap/css/dbtheme.css');
        
        $twig = $this->grav['twig'];
        $gravstrapElements = array();
        $header = $this->grav["page"]->header();
        if (property_exists($header, "gravstrap")) {
            $gravstrapElements = $header->gravstrap;
        }
        
        if (array_key_exists("gravstrap", $twig->twig_vars['site'])) {
            $gravstrapElements = array_merge($twig->twig_vars['site']['gravstrap'], $gravstrapElements);
        }
        
        $gravstrap = array();
        foreach($gravstrapElements as $type => $elements) {
            $template = sprintf('%s.html.twig', $type);
            foreach($elements as $name => $element) {
                if (array_key_exists('from_file', $element)) {
                    $element["sections"] = $this->fetchSectionsFromFile($element['from_file']);
                }
                $gravstrap[$name] = $twig->twig->render($template, array($type => $element));
            }
        }
        
        $twig->twig_vars['gravstrap'] = $gravstrap;
    }
    
    /**
     * Parses the given file to fetch markdown sections.
     * 
     * A section is formatted as following:
     * 
     * [SECTION section-name]
     * Markdown content
     * [/SECTION]
     * 
     * @param type $fileName
     * @return array
     */
    private function fetchSectionsFromFile($fileName)
    {
        $this->grav['twig']->twig_vars['sections'] = array();
        $sectionsFile = $this->grav['page']->path() . '/' . $fileName;
        if (!file_exists($sectionsFile)) {
            return array();
        }
        
        $sectionsContent = file_get_contents($sectionsFile);
        $regex = '/\[SECTION\s([^\]]+)\](.*?)\[\/SECTION\]/si';
        preg_match_all($regex, $sectionsContent, $matches, PREG_SET_ORDER);
        if (!$matches) {
            return array();
        }
        
        $defaults = $this->config->get('system.pages');
        if ($defaults['markdown_extra']) {
            $parsedown = new \ParsedownExtra();
        } else {
            $parsedown = new \Parsedown();
        }
            
        $sections = array();
        foreach($matches as $match) {
            $sectionName = $match[1];
            $sections[$sectionName] = $parsedown->text($match[2]);
        }
        
        return $sections;
    }
}
