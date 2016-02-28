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
 * Class AccordionShortcode handles a bootstrap accordion component
 *
 * @author Giansimon Diblas
 */
class AccordionShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */  
    protected function shortcodeName()
    {
        return 'gravstrap-accordion';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/accordion.html.twig';
    }
    
    /**
     * {@inheritdoc}
     */  
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-accordion-item'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-accordion' => array(
                'g-accordion'
            ),
            'gravstrap-accordion-item' => array(
                'g-accordion-item'
            ),
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
            'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),
        ]);
    }
}