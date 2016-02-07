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

namespace Gravstrap\Bootstrap\Tab;

use Gravstrap\Base\BaseSectionShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Tab handles a bootstrap tab component
 *
 * @author Giansimon Diblas
 */
class Tab extends BaseSectionShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-tab';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/tab.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'items' => $this->sections($shortcode),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
    }
}
