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

namespace Gravstrap\Bootstrap\Listgroup;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class DropdownItems handles a list group item
 *
 * @author Giansimon Diblas
 */
class ListgroupItem extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-listgroup-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/listgroup_item.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'url' => $shortcode->getParameter('url'),
            'type' => $shortcode->getParameter('type'),
            'active' => $shortcode->getParameter('active'),
            'disabled' => $shortcode->getParameter('disabled'),
            'badge' => $shortcode->getParameter('badge'),
            'content' => $this->fixContent($shortcode),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
    }
}
