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
 * Class ButtonShortcode handles a bootstrap button component
 *
 * @author Giansimon Diblas
 */
class ButtonShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-button';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/button.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-button',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'button_label' => $shortcode->getParameter('button_label'),
            'button_type' => $shortcode->getParameter('button_type'),
            'button_attributes' => $shortcode->getParameter('button_attributes'),
            'button_url' => $shortcode->getParameter('button_url'),            
        ]);
    }
}