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
 * Class MapShortcode handles a google map component
 *
 * @author Giansimon Diblas
 */
class MapShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */  
    protected function shortcodeName()
    {
        return 'gravstrap-map';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'misc/map.html.twig';
    }
    
    /**
     * {@inheritdoc}
     */  
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-map-marker'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'css' => array(
                'plugin://gravstrap/css/gravstrap_googlemap.css',    
            ),
            'js' => array(
                'https://maps.googleapis.com/maps/api/js?callback=initMap',
                //'plugin://gravstrap/js/scroll.js',
            ),     
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-map' => array(
                'g-map'
            ),
            'gravstrap-map-marker' => array(
                'g-map-marker'
            ),
        );
    }
    
    /**
     * {@inheritdoc}
     */  
    protected function renderOutput(ShortcodeInterface $shortcode)
    {//echo $shortcode->getParameter('center');exit;
        return $this->twig->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'zoom' => $shortcode->getParameter('zoom'),
            'center' => json_encode(array(
                'lat' => 41.90278,
                'lng' => 12.49637,
            )),
            'markers' => array(
                0 => array(
                'location' => json_encode(array(
                    'lat' => 41.90278,
                    'lng' => 12.49637,
                )),                
                'title' => 'Pippo',
                'info' => '<strong>Meet Us</strong>.<br/>We are there!',
                    ),
            )
            ////$shortcode->getParameter('center'),
            //'name' => $shortcode->getParameter('name'),
            //'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),
        ]);
    }
}