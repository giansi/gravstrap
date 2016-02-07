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
 * Class Link handles a link element
 *
 * @author Giansimon Diblas
 */
class Link extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'link';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'url' => $shortcode->getParameter('url'),
            'menu' => $shortcode->getParameter('menu'),
            'icon_type' => $this->findParameterInCascade($shortcode, 'icon_type'),
            'icon' => $shortcode->getParameter('icon'),
            'icon_container' => $shortcode->getParameter('icon_container'),
            'stacked' => $this->stringToBoolean($shortcode->getParameter('stacked')),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
    }
}
