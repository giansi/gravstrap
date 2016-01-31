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

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Tab handles a bootstrap tab component
 *
 * @author Giansimon Diblas
 */
abstract class BaseSectionShortcode extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function sections(ShortcodeInterface $shortcode)
    {
        $items = array();
        $registeredItems = RegisteredShortcodes::get($this->getShortcodeHash($shortcode));
        foreach ($registeredItems as $value) {
            if (!is_array($value)) {
                continue;
            }
            $name = key($value);
            $items[$name] = $value[$name];
        }
        
        return $items;
    }
}
