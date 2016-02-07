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

namespace Gravstrap\Basic;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class IconStacked handles a stacked icon element
 *
 * @author Giansimon Diblas
 */
class IconStacked extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'icon-stacked';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'icon' => $shortcode->getParameter('icon'),
            'large_icon' => $this->stringToBoolean($shortcode->getParameter('large_icon')),
            'icon_container' => $shortcode->getParameter('icon_container'),
        ]);
    }
}
