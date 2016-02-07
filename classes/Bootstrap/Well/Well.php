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

namespace Gravstrap\Bootstrap\Well;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Well handles a bootstrap well component
 *
 * @author Giansimon Diblas
 */
class Well extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-well';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/well.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $wellSize = $shortcode->getParameter('size');
        switch($wellSize) {
            case 'small':
                $wellSize = 'sm';
                break;
            case 'large':
                $wellSize = 'lg';
                break;
        }
        
        return $this->grav['twig']->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'size' => $wellSize,
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
