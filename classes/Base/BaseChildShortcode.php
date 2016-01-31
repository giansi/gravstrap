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
 * Class BaseChildShortcode defines the base class to implement an object which can be used as a child into a shortcode collection
 *
 * @author Giansimon Diblas
 */
abstract class BaseChildShortcode extends BaseShortcode
{
    /**
     * @var ShortcodeInterface 
     */
    private $parentShortcode;
    /**
     * @var string
     */
    private $parentHash;
    
    /**
     * Returns the parent shortcode 
     * 
     * @return ShortcodeInterface
     */
    public function parentShortcode()
    {
        return $this->parentShortcode;
    }
    
    /**
     * Returns the parent shortcode hash
     * 
     * @return string
     */
    public function parentHash()
    {
        return $this->parentHash;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderShortcode(ShortcodeInterface $shortcode)
    {
        $this->fetchParentInformation($shortcode);
        $output = $this->renderOutput($shortcode);
        $this->registerOutput($output);
    }
    
    /**
     * Fetches the parent and its has from the given shortcode
     * 
     * @param ShortcodeInterface $shortcode
     */
    protected function fetchParentInformation(ShortcodeInterface $shortcode)
    {
        $this->parentShortcode = $shortcode->getParent();
        $this->parentHash = $this->getShortcodeHash($this->parentShortcode);
    }
    
    /**
     * Registers the given output for the handled shortcode parent
     * 
     * @param mixed $output
     */
    protected function registerOutput($output)
    {
        RegisteredShortcodes::register($this->parentHash, $output);
    }
}
