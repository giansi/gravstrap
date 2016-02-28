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

namespace Grav\Plugin\Shortcodes;

use Grav\Common\Page\Page;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class NavbarMenuShortcode handles a navbar menu item
 *
 * @author Giansimon Diblas
 */
class NavbarMenuShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-navbar-menu';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/partials/_navbar_menu.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-navbar-menu',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $items = RegisteredShortcodes::get($this->shortcode->getId($shortcode));
        if (null === $items || empty($items)) {
            $items = $this->buildMenu($shortcode);
        }

        $output = $this->grav['twig']->processTemplate($this->template(), [
            'alignment' => $shortcode->getParameter('alignment'),
            'attributes' => $shortcode->getParameter('attributes'),
            'items' => $items,
            'onepage' => ($shortcode->getParameter('onepage') == "true") ? true :false,
        ]);
        
        return $output;
    }

    private function buildMenu(ShortcodeInterface $shortcode, $pageName = null, $showHidden = false)
    {
        $submenu = explode(',', $shortcode->getParameter('submenu'));

        $result = array();
        $pages = (null === $pageName)
            ?
                $this->grav['pages']->root()->children()
            :
                $this->grav['page']->find('/' . $pageName)->children()
            ;

        foreach($pages as $page) {
            if ( ! ($showHidden || $page->visible()) || ! $page->published()) {
                continue;
            }

            // Looks for a navbar configuration for the current page
            $header = $page->header();
            $configuration = array();
            if (  property_exists($header, 'navbar_configuration')) {
                $configuration = $header->navbar_configuration;
            }

            $output = "";
            $tokens = explode('.', $page->folder());
            if (null !== $submenu && in_array($tokens[1], $submenu)) {
                $dropdown = $this->addDropdown($page);
                $output = $this->grav['twig']->processTemplate('bootstrap/partials/_navbar_dropdown.html.twig', $dropdown);
            }

            $params = array(
                'url' => $page->url(),
                'menu' => $page->menu(),
            );

            if (array_key_exists("button", $configuration)) {
                $params = array_merge($configuration["button"], $params);
                $output = $this->grav['twig']->processTemplate('bootstrap/partials/_navbar_button.html.twig', $params);
            }

            if (empty($output)) {
                $output = $this->grav['twig']->processTemplate('basic/link.html.twig', $params);
            }

            $result[] = $output;
        }

        return $result;
    }


    private function addLink(Page $page, $type = 'link')
    {
        return array(
            'menu' => $page->menu(),
            'url' => $page->url(),
            'type' => $type,
        );
    }

    private function addDropdown(Page $page)
    {
        $dropdownItems = array();
        $children = $page->children();
        foreach ($children as $child) {
            if ( ! $child->published()) {
                continue;
            }

            $dropdownItems[] = $this->addLink($child);
        }

        $dropdown = $this->addLink($page, 'dropdown');
        $dropdown['items'] = $dropdownItems;
        
        return $dropdown;
    }
}
