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

namespace Gravstrap\Bootstrap\Thumbnail;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class ThumbnailItem handles a thumbnail item
 *
 * @author Giansimon Diblas
 */
class ThumbnailItem extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-thumbnail-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/thumbnail_item.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {        
        return $this->grav['twig']->processTemplate($this->template(), [
            'image' => $shortcode->getParameter('image'),
            'url' => $shortcode->getParameter('url'),
            'content' => $this->fixContent($shortcode),
        ]);
    }
}
