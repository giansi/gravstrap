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
 * Class ThumbnailShortcode handles a bootstrap thumbnail component
 *
 * @author Giansimon Diblas
 */
class ThumbnailShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-thumbnail';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-thumbnail-item'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/thumbnail.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-thumbnail' => array(
                'g-thumbnail'
            ),
            'gravstrap-thumbnail-item' => array(
                'g-thumbnail-item'
            ),
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),
        ]);
    }
}