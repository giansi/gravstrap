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
 * Class Progressbar handles a bootstrap progressbar component
 *
 * @author Giansimon Diblas
 */
class ProgressbarShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-progressbar';
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'css' => array(                  
                'plugin://gravstrap/css/gravstrap_progressbar.css',   
            ),      
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/progressbar.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-progressbar',
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
            'type' => $shortcode->getParameter('type'),
            'striped' => $this->stringToBoolean($shortcode->getParameter('striped')),
            'animated' => $this->stringToBoolean($shortcode->getParameter('animated')),
            'value' => $shortcode->getParameter('value'),
            'min' => $shortcode->getParameter('min'),
            'max' => $shortcode->getParameter('max'),
            'attributes' => $shortcode->getParameter('attributes'),
        ]);
    }
}