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
 * Class LinkShortcode handles a link element
 *
 * @author Giansimon Diblas
 */
class LinkShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-link';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/link.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-link',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'url' => $shortcode->getParameter('url'),
            'menu' => $shortcode->getParameter('menu'),
            'icon_type' => $this->findParameterInCascade($shortcode, 'icon_type'),
            'icon' => $shortcode->getParameter('icon'),
            'icon_container' => $shortcode->getParameter('icon_container'),
            'stacked' => $this->stringToBoolean($shortcode->getParameter('stacked')),
            'link_attributes' => $shortcode->getParameter('attributes'),
        ]);
    }
}
