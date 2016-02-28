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
 * Class PageHeaderShortcode handles a bootstrap pageheader component
 *
 * @author Giansimon Diblas
 */
class PanelShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-panel';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/panel.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-panel',
        );
    }
    
    /**
     * {@inheritdoc}
     */ 
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'heading_title' => $shortcode->getParameter('heading_title'),
            'footer_title' => $shortcode->getParameter('footer_title'),
            'type' => $shortcode->getParameter('type'),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}