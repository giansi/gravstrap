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

namespace Gravstrap\Modules\Contacts;

use Gravstrap\Base\BaseSectionShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Contacts handles a module to show company information and a form to send an email
 *
 * @author Giansimon Diblas
 */
class Contacts extends BaseSectionShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'contacts';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'plugin://gravstrap/css/gravstrap_contacts.css',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/contacts/contacts.html.twig';
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
            'form_position' => $shortcode->getParameter('form_position'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')), 
            'form_attributes' => $this->parseAttributes($shortcode->getParameter('form_attributes')), 
            'info_attributes' => $this->parseAttributes($shortcode->getParameter('info_attributes')), 
        ]);
    }
}
