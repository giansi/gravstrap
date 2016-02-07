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

namespace Gravstrap\Modules\ContactsMap;

use Gravstrap\Base\BaseSectionShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class ContactsMap handles a module to show company information and a map
 *
 * @author Giansimon Diblas
 */
class ContactsMap extends BaseSectionShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'contacts-map';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'plugin://gravstrap/css/gravstrap_where_we_are.css',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/contacts_map/contacts_map.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [ 
            'id' => $shortcode->getParameter('id'),  
            'content' => $this->fixContent($shortcode),
            'sections' => $this->sections($shortcode),
            'map_position' => $shortcode->getParameter('map_position'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')), 
            'map_attributes' => $this->parseAttributes($shortcode->getParameter('map_attributes')), 
            'info_attributes' => $this->parseAttributes($shortcode->getParameter('info_attributes')), 
        ]);
    }
}
