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

use Grav\Common\Plugin;
use Gravstrap\Twig\GravstrapTwigExtension;
use Grav\Common\Page\Page;

class GravstrapPlugin extends Plugin
{    
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
            'onTwigExtensions' => ['onTwigExtensions', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ];
    }

    /**
     * Initializes the shortcodes
     */
    public function onShortcodeHandlers()
    {
        require_once(__DIR__.'/classes/Base/GravstrapShortcode.php');
        require_once(__DIR__.'/classes/Base/RegisteredShortcodes.php');
        require_once(__DIR__.'/classes/Twig/GravstrapTwigExtension.php');
        
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Basic');        
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Bootstrap');   
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Footer'); 
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Modules');
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Misc');
        $this->grav["shortcode"]->registerAllShortcodes(__DIR__.'/shortcodes/Vendor');
    }

    /**
     * Adds Twig extension
     */
    public function onTwigExtensions()
    {
        require_once(__DIR__ . '/classes/Twig/GravstrapTwigExtension.php');
        
        $this->grav['twig']->twig->addExtension(new GravstrapTwigExtension());
    }
    
    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates/modules';
    }

    /**
     * Assigns not rendered shortcodes to twig variables; adds modular pages assets; parses common page
     */
    public function onTwigSiteVariables()
    {      
        $page = $this->grav['page'];
        $this->pageShortcodesToTwigVariable($page);
        $this->manageModularPage($page);
        
        $page = $page->find('/common');
        if (null === $page) {
            return;
        }
            
        $page->content();
        $this->pageShortcodesToTwigVariable($page);
        $this->addAssets($page);
    }
    
    private function pageShortcodesToTwigVariable(Page $page)
    {
        $contentMeta = $page->getcontentMeta();
        if (null === $contentMeta || ! array_key_exists("shortcode", $contentMeta) || null === $shortcodes = $contentMeta["shortcode"]) {
            return;
        }
        
        foreach($shortcodes as $typedShortcodes) {
            foreach($typedShortcodes as $name => $content) {
                $this->grav['twig']->twig_vars[$name] = $content;
            }
        }
    }
    
    private function manageModularPage(Page $page)
    {
        $children = $page->collection();
        foreach ($children as $child) {
           if (!$child->modular()) {
               return;
           }
           
           $this->addAssets($child);
        }
    }
    
    private function addAssets(Page $page)
    {
        // get the meta and check for assets
        $meta = $page->getContentMeta();
        if (!isset($meta['shortcode-assets'])) {
            return;
        }
        
        $assets = (array) $meta['shortcode-assets'];
        foreach($assets as $type => $asset) {
            switch ($type) {
                case 'css':
                    $this->grav["assets"]->addCss($asset);
                    break;
                case 'js':
                    $this->grav["assets"]->addJs($asset);
                    break;
            }
        }
    }
}
