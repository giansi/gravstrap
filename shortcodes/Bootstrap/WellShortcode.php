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
 * Class Well handles a bootstrap well component
 *
 * @author Giansimon Diblas
 */
class WellShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-well';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/well.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-well',
        );
    }
    
    /**
     * {@inheritdoc}
     */ 
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $wellSize = $shortcode->getParameter('size');
        switch($wellSize) {
            case 'small':
                $wellSize = 'sm';
                break;
            case 'large':
                $wellSize = 'lg';
                break;
        }
        
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'size' => $wellSize,
            'attributes' => $shortcode->getParameter('attributes'),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}