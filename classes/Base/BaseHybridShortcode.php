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

namespace Gravstrap\Base;

use Gravstrap\Base\BaseChildShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class BaseHybridShortcode defines the base class to implement an object which can be directly rendered or that it can be used as a child into a shortcode collection
 *
 * @author Giansimon Diblas
 */
abstract class BaseHybridShortcode extends BaseChildShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function renderShortcode(ShortcodeInterface $shortcode)
    {
        $this->fetchParentInformation($shortcode);
        $output = $this->renderOutput($shortcode);
        if (null ===  $this->parentShortcode()) {
            return $output;
        }

        $this->registerOutput($output);
    }
}
