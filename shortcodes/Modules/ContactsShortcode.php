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
 * Class Contacts handles a module to show company information and a form to send an email
 *
 * @author Giansimon Diblas
 */
class ContactsShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-contacts';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(  
            'css' => array(              
                'plugin://gravstrap/css/gravstrap_contacts.css',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/contacts.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-contacts',
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
            'form_position' => $shortcode->getParameter('form_position'),
            'attributes' => $shortcode->getParameter('attributes'), 
            'form_attributes' => $shortcode->getParameter('form_attributes'), 
            'info_attributes' => $shortcode->getParameter('info_attributes'), 
        ]);
    }
}
