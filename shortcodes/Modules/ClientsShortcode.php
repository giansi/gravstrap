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
 * Class ClientsShortcode handles a module to show a gallery of clients
 *
 * @author Giansimon Diblas
 */
class ClientsShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-clients';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-clients-item'
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'css' => array(                  
                'plugin://gravstrap/css/gravstrap_clients.css',  
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/clients.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-clients' => array(
                'g-clients'
            ),
            'gravstrap-clients-item' => array(
                'g-clients-item'
            ),
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'content' => $this->fixContent($shortcode),   
            'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),   
            'attributes' => $shortcode->getParameter('attributes'), 
            'column_attributes' => $shortcode->getParameter('column_attributes'), 
        ]);
    }
}