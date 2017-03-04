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
 * Class ModalShortcode handles a bootstrap modal component
 *
 * @author Giansimon Diblas
 */
class GravstrapModalShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-modal';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-modal-buttons'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/modal.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-modal' => array(
                'g-modal'
            ),
            'gravstrap-modal-buttons' => array(
                'g-modal-buttons'
            ),
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'name' => $shortcode->getParameter('name'),
            'title' => $shortcode->getParameter('title'),
            'attributes' => $shortcode->getParameter('attributes'),
            'close_button_attributes' => $shortcode->getParameter('close_button_attributes'),
            'content' => $this->fixContent($shortcode),
            'buttons' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),
        ]);
    }
}
