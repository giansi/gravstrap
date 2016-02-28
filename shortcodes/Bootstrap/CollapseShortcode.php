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
 * Class CollapseShortcode handles a bootstrap collapse component
 *
 * @author Giansimon Diblas
 */
class CollapseShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-collapse';
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
    protected function aliases()
    {
        return array(
            'g-collapse',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'name' => $shortcode->getParameter('name'),
            'tag' => $this->defaultValue($shortcode->getParameter('tag'), 'button'),
            'button_type' => $shortcode->getParameter('button_type'),
            'button_label' => $shortcode->getParameter('button_label'),
            'items' => RegisteredShortcodes::get($this->shortcode->getId($shortcode)),
            'attributes' => $shortcode->getParameter('attributes'),
        ]);
    }
}
