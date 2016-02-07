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

namespace Gravstrap\Bootstrap\Navbar;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Navbar handles a bootstrap navbar component
 *
 * @author Giansimon Diblas
 */
class Navbar extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-navbar';
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'plugin://gravstrap/css/gravstrap_navbar.css',
            'plugin://gravstrap/js/gravstrap_navbar.js',
            'plugin://gravstrap/js/scroll.js',
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
            'fixed' => $shortcode->getParameter('fixed'),
            'container' => $this->stringToBoolean($shortcode->getParameter('container')),
            'brand_text' => $shortcode->getParameter('brand_text'),
            'brand_image' => $shortcode->getParameter('brand_image'),            
            'inverse' => $this->stringToBoolean($shortcode->getParameter('inverse')),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
        ]);
    }
}
