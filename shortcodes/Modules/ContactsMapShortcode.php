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
 * Class ContactsMapShortcode handles a module to show company information and a map
 *
 * @author Giansimon Diblas
 */
class ContactsMapShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-contacts-map';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(   
            'css' => array(          
                'plugin://gravstrap/css/gravstrap_where_we_are.css',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/contacts_map.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-contacts-map',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [ 
            'name' => $shortcode->getParameter('name'),  
            'content' => $this->fixContent($shortcode),
            'sections' => $this->sections($shortcode),
            'map_position' => $shortcode->getParameter('map_position'),
            'attributes' => $shortcode->getParameter('attributes'), 
            'map_attributes' => $shortcode->getParameter('map_attributes'), 
            'info_attributes' => $shortcode->getParameter('info_attributes'), 
        ]);
    }
}
