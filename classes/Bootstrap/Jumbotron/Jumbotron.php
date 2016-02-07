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

namespace Gravstrap\Bootstrap\Jumbotron;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class AccordionItem handles a bootstrap jumbotron component
 *
 * @author Giansimon Diblas
 */
class Jumbotron extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-jumbotron';
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'plugin://gravstrap/css/gravstrap_jumbotron.css',            
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/jumbotron.html.twig';
    }    
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'image' => $shortcode->getParameter('image'),
            'fullwidth' => $shortcode->getParameter('fullwidth'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
