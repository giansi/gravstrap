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
 * Class ListShortcode handles a generic list
 *
 * @author Giansimon Diblas
 */
class ListShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-list';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/list.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $tag = null !== $shortcode->getParameter('tag') ? $shortcode->getParameter('tag') : 'ul';
        $items = RegisteredShortcodes::get($this->shortcode->getId($shortcode));
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'list_attributes' => $shortcode->getParameter('attributes'),
            'items' => $items,
            'tag' => $tag,
        ]);
        
        return $output;
    }
}