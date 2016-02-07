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

namespace Gravstrap\Modules\WhatWeDo;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class WhatWeDoItem handles a WhatWeDo item
 *
 * @author Giansimon Diblas
 */
class WhatWeDoItem extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'what-we-do-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/what_we_do/what_we_do_item.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $this->fetchParentInformation($shortcode);
        $name = $shortcode->getParameter('name');
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'name' => $name,
            'content' => $this->fixContent($shortcode),
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
        $this->registerOutput($output);
    }
}
