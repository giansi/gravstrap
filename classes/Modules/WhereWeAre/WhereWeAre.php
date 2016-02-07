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

namespace Gravstrap\Modules\WhereWeAre;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class WhereWeAre handles a module to show a map
 *
 * @author Giansimon Diblas
 */
class WhereWeAre extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'where-we-are';
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
        return 'modules/where_we_are/where_we_are.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [    
            'content' => $this->fixContent($shortcode),   
            'id' => $shortcode->getParameter('id'),  
            'fullwidth' => $this->stringToBoolean($shortcode->getParameter('fullwidth')),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')), 
        ]);
    }
}
