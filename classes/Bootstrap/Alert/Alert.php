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

namespace Gravstrap\Bootstrap\Alert;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Alert handles a bootstrap alert component
 *
 * @author Giansimon Diblas
 */
class Alert extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-alert';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'type' => $shortcode->getParameter('type'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
