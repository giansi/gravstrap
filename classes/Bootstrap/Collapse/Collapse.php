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

namespace Gravstrap\Bootstrap\Collapse;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Carousel handles a bootstrap collapse component
 *
 * @author Giansimon Diblas
 */
class Collapse extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-collapse';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/collapse.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'tag' => $this->defaultValue($shortcode->getParameter('tag'), 'button'),
            'button_type' => $shortcode->getParameter('button_type'),
            'button_label' => $shortcode->getParameter('button_label'),
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
    }
}
