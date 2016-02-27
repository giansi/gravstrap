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
 * Class ListItemShortcode handles a list item
 *
 * @author Giansimon Diblas
 */
class ListItemShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-list-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/list-item.html.twig';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'item_attributes' => $shortcode->getParameter('attributes'),
            'content' => $shortcode->getContent(),
        ]);
                    
        return $output;
    }
}
