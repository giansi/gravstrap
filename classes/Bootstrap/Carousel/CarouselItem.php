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
 * Class CarouselItem handles a carousel item
 *
 * @author Giansimon Diblas
 */
class CarouselItem extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-carousel-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/carousel_item.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'image' => $shortcode->getParameter('image'),
            'caption' => $this->fixContent($shortcode),
            'is_first' => count(RegisteredShortcodes::get($this->parentHash())) == 0,
        ]);
    }
}
