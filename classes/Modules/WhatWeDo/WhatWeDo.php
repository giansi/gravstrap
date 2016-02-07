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

namespace Gravstrap\Modules\WhatWeDo;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class WhatWeDo handles a module to show company business
 *
 * @author Giansimon Diblas
 */
class WhatWeDo extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'what-we-do';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'plugin://gravstrap/css/gravstrap_what_we_do.css',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/what_we_do/what_we_do.html.twig';
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
