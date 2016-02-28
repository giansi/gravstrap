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
 * Class IconStackedShortcode handles a stacked icon element
 *
 * @author Giansimon Diblas
 */
class IconStackedShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-icon-stacked';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/icon_stacked.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-icon-stacked',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'icon' => $shortcode->getParameter('icon'),
            'large_icon' => $this->stringToBoolean($shortcode->getParameter('large_icon')),
            'icon_container' => $shortcode->getParameter('icon_container'),
        ]);
    }
}
