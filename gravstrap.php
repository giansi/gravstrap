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
use \Grav\Common\Page\Page;

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
        $config = $this->grav["config"]->get('plugins.gravstrap');
        
        $twig = $this->grav['twig'];
        $gravstrapComponents = array();
        $header = $this->grav["page"]->header();
        if (property_exists($header, "gravstrap")) {
            $gravstrapComponents = $header->gravstrap;
            $collection = $this->grav['page']->collection();
            $gravstrapComponents = array_merge($gravstrapComponents, $this->parseChildren($collection));
        }
        
        if (array_key_exists("gravstrap", $twig->twig_vars['site'])) {
            $gravstrapComponents = array_merge_recursive($twig->twig_vars['site']['gravstrap'], $gravstrapComponents);
        }
        
        $sections = $twig->twig_vars['sections'];
        $gravstrap = array();
        $gravstrapCollection = array();
        foreach($gravstrapComponents as $type => $components) {
            $components = $this->configureElement($type, $config, $components);            
            $template = sprintf('%s.html.twig', $type);
            foreach($components as $name => $element) {
                if (array_key_exists('from_file', $element)) {
                    $element["sections"] = $sections["page"][$element['from_file']];
                }
                $gravstrapCollection[$type][] = $gravstrap[$name] = $twig->twig->render($template, array($type => $element));
            }
        }
        
        $twig->twig_vars['gravstrap'] = $gravstrap;
        $twig->twig_vars['gravstrap_collection'] = $gravstrapCollection;
    }
    
    protected function parseChildren($children)
    {
        if (is_array($children)) {
            return array();
        }
        
        $modules = $children->modular();
        if (count($modules) == 0) {
            return array();
        }
        
        $configurations = array();
        foreach($children as $child) {
            $header = $child->header();
            if (property_exists($header, "gravstrap")) {
                $gravstrapComponents = $this->addModulePageToGravstrap($header->gravstrap, $child);
                
                $configurations = array_merge($configurations, $gravstrapComponents);
            }
        }
        
        return $configurations;
    }
    
    private function addModulePageToGravstrap($configuration, Page $page)
    {
        $gravstrapComponents = array(); 
        foreach($configuration as $name => $values) {
            foreach($values as $name1 => $value1) {
                $gravstrapComponents[$name][$name1] = array_merge(array(
                    'page' => $page,
                ), $value1);
            }
        }
        
        return $gravstrapComponents;
    }
    
    private function configureElement($type, $config, $components)
    {
        if ( ! array_key_exists($type, $config)) {
            return $components;
        }
        
        $className = ucfirst($type);
        $classFile = __DIR__ . sprintf('/classes/%s.php', $className);
        if (!file_exists($classFile)) {
            return $components;
        }
        
        require_once $classFile;
        $className = 'Grav\\Plugin\\' . $className;
        $element = new $className($this->grav);
        $element->process($config[$type], $components);
        
        return $element->processedComponents();
    }
}