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
 * Class JumbotronShortcode handles a bootstrap jumbotron component
 *
 * @author Giansimon Diblas
 */
class GravstrapJumbotronShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */  
    protected function shortcodeName()
    {
        return 'gravstrap-jumbotron';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/jumbotron.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-jumbotron',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'css' => array(        
                'plugin://gravstrap/css/gravstrap_jumbotron.css',   
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
            'image' => $shortcode->getParameter('image'),
            'fullwidth' => $shortcode->getParameter('fullwidth'),
            'attributes' => $shortcode->getParameter('attributes'),
            'content' => $shortcode->getContent(),
        ]);
    }
}