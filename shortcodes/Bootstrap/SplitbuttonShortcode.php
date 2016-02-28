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
 * Class SplitbuttonShortcode handles a bootstrap splitbutton component
 *
 * @author Giansimon Diblas
 */
class SplitbuttonShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-splitbutton';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/splitbutton.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-splitbutton',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'label' => $shortcode->getParameter('label'),
            'dropup' => $this->stringToBoolean($shortcode->getParameter('dropup')),
            'type' => $shortcode->getParameter('type'),
            'items' => RegisteredShortcodes::get($this->shortcode->getId($shortcode)),
        ]);
    }
}
