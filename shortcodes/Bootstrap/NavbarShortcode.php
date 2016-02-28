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

use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class NavbarShortcode handles a bootstrap navbar component
 *
 * @author Giansimon Diblas
 */
class NavbarShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-navbar';
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'css' => array(
                'plugin://gravstrap/css/gravstrap_navbar.css',    
            ),
            'js' => array(
                'plugin://gravstrap/js/gravstrap_navbar.js',
                'plugin://gravstrap/js/scroll.js',
            ),         
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-navbar',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/navbar.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'name' => $shortcode->getParameter('name'),
            'fixed' => $shortcode->getParameter('fixed'),
            'container' => $this->stringToBoolean($shortcode->getParameter('container')),
            'brand_text' => $shortcode->getParameter('brand_text'),
            'brand_image' => $shortcode->getParameter('brand_image'),            
            'inverse' => $this->stringToBoolean($shortcode->getParameter('inverse')),
            'attributes' => $shortcode->getParameter('attributes'),
            'items' => RegisteredShortcodes::get($this->shortcode->getId($shortcode)),
        ]);
    }
}
