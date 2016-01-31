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

namespace Gravstrap\Navbar;

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
            'centering' => $shortcode->getParameter('centering'),
            'brand_text' => $shortcode->getParameter('brand_text'),
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
        ]);
    }
}
