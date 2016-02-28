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
 * Class Carousel handles a bootstrap carousel component
 *
 * @author Giansimon Diblas
 */
class CarouselShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-carousel';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/carousel.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-carousel' => array(
                'g-carousel'
            ),
            'gravstrap-carousel-item' => array(
                'g-carousel-item'
            ),
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-carousel-item'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'name' => $shortcode->getParameter('name'),
            'previous_label' => $this->defaultValue($shortcode->getParameter('previous_label'), 'Previous'),
            'next_label' => $this->defaultValue($shortcode->getParameter('next_label'), 'Next'),
            'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),
        ]);
    }
}