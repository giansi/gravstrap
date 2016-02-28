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
 * Class AlertShortcode handles a bootstrap alert component
 *
 * @author Giansimon Diblas
 */
class AlertShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */    
    protected function shortcodeName()
    {
        return 'gravstrap-alert';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/alert.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-alert',
        );
    }
    
    /**
     * {@inheritdoc}
     */  
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'type' => $shortcode->getParameter('type'),
            'attributes' => $shortcode->getParameter('attributes'),
            'content' => $shortcode->getContent(),
        ]);
    }
}