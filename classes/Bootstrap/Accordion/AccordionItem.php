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

namespace Gravstrap\Bootstrap\Accordion;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class AccordionItem handles an accordion item
 *
 * @author Giansimon Diblas
 */
class AccordionItem extends BaseShortcode
{    
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-accordion-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/accordion_item.html.twig';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'parent_id' => $this->parentShortcode()->getParameter('id'),
            'heading_id' => $shortcode->getParameter('heading_id'),
            'title' => $shortcode->getParameter('title'),
            'is_first' => count(RegisteredShortcodes::get($this->parentHash())) == 0,
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
