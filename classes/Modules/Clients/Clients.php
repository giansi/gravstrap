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

namespace Gravstrap\Modules\Clients;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Clients handles a module to show a gallery of clients
 *
 * @author Giansimon Diblas
 */
class Clients extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'clients';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'plugin://gravstrap/css/gravstrap_clients.css',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/clients/clients.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [    
            'content' => $this->fixContent($shortcode),   
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),   
            'id' => $shortcode->getParameter('id'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')), 
            'column_attributes' => $this->parseAttributes($shortcode->getParameter('column_attributes')), 
        ]);
    }
}
