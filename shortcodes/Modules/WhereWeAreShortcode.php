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
 * Class WhereWeAreShortcode handles a module to show a bootstrap thumbnails portfolio
 *
 * @author Giansimon Diblas
 */
class WhereWeAreShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-where-we-are';
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
        return 'modules/where_we_are.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-where-we-are',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'content' => $this->fixContent($shortcode),   
            'name' => $shortcode->getParameter('name'),  
            'fullwidth' => $this->stringToBoolean($shortcode->getParameter('fullwidth')),
            'attributes' => $shortcode->getParameter('attributes'), 
        ]);
    }
}