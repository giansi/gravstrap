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

namespace Gravstrap\Bootstrap\Panel;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Panel handles a bootstrap panel component
 *
 * @author Giansimon Diblas
 */
class Panel extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-panel';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'heading_title' => $shortcode->getParameter('heading_title'),
            'footer_title' => $shortcode->getParameter('footer_title'),
            'type' => $shortcode->getParameter('type'),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
