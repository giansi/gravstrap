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
 * Class GravstrapSectionShortcode handles a generic child markdown section
 *
 * @author Giansimon Diblas
 */
class GravstrapSectionShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcodeName()
    {
        return 'gravstrap-section';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'basic/section.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-section',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $name = $shortcode->getParameter('name');
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'name' => $name,
            'content' => $this->fixContent($shortcode),
            'attributes' => $shortcode->getParameter('attributes')
        ]);
        
        $this->registerOutput($shortcode, array($name => $output));
    }
}
