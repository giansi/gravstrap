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

namespace Gravstrap;

/**
 * Defines the base interface to handle a Bootstrap Component
 * 
 * @author Giansimon Diblas
 */
interface ComponentInterface
{
    /**
     * Processes the component from the given configuration
     * 
     * @param array $config
     * @param array $components
     */
    public function process(array $config, array $components);
    
    /**
     * Returns the processed components
     * 
     * @return array
     */
    public function processedComponents();
}
