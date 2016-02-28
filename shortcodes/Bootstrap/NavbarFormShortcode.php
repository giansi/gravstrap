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

use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class NavbarFormShortcode handles a navbar form component
 *
 * @author Giansimon Diblas
 */
class NavbarFormShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-navbar-form';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/partials/_navbar_form.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-navbar-form',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'alignment' => $shortcode->getParameter('alignment'),
            'placeholder' => $shortcode->getParameter('placeholder'),
            'button_visible' => $this->stringToBoolean($shortcode->getParameter('button_visible')),
            'button_type' => $shortcode->getParameter('button_type'),
            'button_label' => $shortcode->getParameter('button_label'),
            'button_attributes' => $shortcode->getParameter('button_attributes'),
        ]);
    }
}
