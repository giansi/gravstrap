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

namespace Gravstrap\Basic;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Section handles a generic markdown section
 *
 * @author Giansimon Diblas
 */
class Section extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'section';
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
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $name = $shortcode->getParameter('name');
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'name' => $name,
            'content' => $this->fixContent($shortcode),
        ]);
        
        //return array($name => $output);
        $this->registerOutput(array($name => $output));
    }
}
