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

namespace Gravstrap;

use Grav\Common\Page\Page;
use Gravstrap\BaseComponent;

/**
 * Class Navbar handles a navbar component
 *
 * @author Giansimon Diblas
 */
class Navbar extends BaseComponent
{
    /**
     * {@inheritdoc}
     */
    protected function processComponents(array $components)
    {
        $pages = $this->grav['pages']->root()->children();
        foreach($pages as $page) {
            if ( ! $page->visible() || ! $page->published()) {
                continue;
            }
            
            // Looks for a navbar configuration for the current page 
            $header = $page->header();
            $configuration = array();
            if (  property_exists($header, 'navbar_configuration')) {
                $configuration = $header->navbar_configuration;
            }
            
            // Finds the current toolbar and menu
            $navbarName = $this->findNavbar($components, $configuration);
            $menuName = $this->findMenu($components[$navbarName], $configuration);
            
            // Renders the page as a dropdown, when required
            if (array_key_exists('submenu', $configuration)) {
                $components[$navbarName]['items'][$menuName]['items'][] = $this->addDropdown($page, $configuration);
                
                continue;
            }
            
            // Renders the page as a link or button
            $type = array_key_exists('type', $configuration) ? $configuration['type'] : 'link';            
            $components[$navbarName]['items'][$menuName]['items'][] = $this->addLink($page, $configuration, $type);            
        }
        
        $this->components = $components;
    }
    
    private function findNavbar(array $components, array $configuration)
    {
        $navbarName = key($components);
        if (array_key_exists('navbar', $configuration) && array_key_exists($configuration['navbar'], $components)) {
            $navbarName = $configuration['navbar'];
        }
        
        return $navbarName;
    }
    
    private function findMenu(array $navbar, array $configuration)
    {        
        if (array_key_exists('menu_item', $configuration)) {
            return $configuration['menu_item'];
        }
        
        if (array_key_exists('items', $navbar)) {
            foreach($navbar['items'] as $menuName => $item) {
                if ($item['type'] == 'menu') {
                    return $menuName;
                }
            }
        }
        
        return 'menu0'; 
    }
    
    private function addLink(Page $page, array $configuration, $type = 'link')
    {
        return array_merge(array(
                'menu' => $page->menu(),
                'url' => $page->url(),
                'type' => $type,
            ), $configuration);
    }
    
    private function addDropdown(Page $page, array $configuration)
    {
        $dropdownItems = array();
        $children = $page->children();
        foreach ($children as $child) {
            if ( ! $child->published()) {
                continue;
            }
            
            $dropdownItems[] = $this->addLink($child, $configuration);
        }
        
        $dropdown = $this->addLink($page, $configuration, 'dropdown');
        $dropdown['items'] = $dropdownItems;
        
        return $dropdown;
    }
}