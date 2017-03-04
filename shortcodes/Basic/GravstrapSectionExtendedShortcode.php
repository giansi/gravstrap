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
 * Class SectionExtendedShortcode handles a Shortcore section section extended with attributes
 *
 * @author Giansimon Diblas
 */
class GravstrapSectionExtendedShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-section-extended';
    } 
    
    /**
     * {@inheritdoc}
     */
    protected function template()
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-section-extended',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $values = array(
            'attributes' => $shortcode->getParameter('attributes'),
            'content' => $shortcode->getContent()
        );
        
        $this->registerSection($shortcode, $values);
        
        return '';
    }
}