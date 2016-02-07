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

namespace Gravstrap\Bootstrap\Carousel;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Carousel handles a bootstrap carousel component
 *
 * @author Giansimon Diblas
 */
class Carousel extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-carousel';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
            'previous_label' => $this->defaultValue($shortcode->getParameter('previous_label'), 'Previous'),
            'next_label' => $this->defaultValue($shortcode->getParameter('next_label'), 'Next'),
        ]);
    }
}
