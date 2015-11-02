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

namespace Grav\Plugin;

use Grav\Common\Grav;

require_once(__DIR__ . '/ComponentInterface.php');

/**
 * Class BaseComponent defines the base object that handles a Bootstrap component
 *
 * @author Giansimon Diblas
 */
abstract class BaseComponent implements ComponentInterface
{        
    /**
     * Component configuration
     * 
     * @var array
     */
    protected $config;
    
    /**
     * Constructor
     * 
     * @param Grav $grav
     */
    public function __construct(Grav $grav)
    {
        $this->grav = $grav;
    }
    
    /**
     * {@inheritdoc}
     */
    public function process(array $config)
    {
        $this->config = $config;
        if ( ! $this->config["enhanced"]) {
            return;
        }
        
        $this->addAssets();
    }

    private function addAssets()
    {
        foreach($this->config["assets"] as $type => $assets) {
            
            $this->add($type, $assets);
        }
    }
    
    private function add($type, $assets)
    {
        foreach($assets as $asset) {
            $assetPath = sprintf('plugin://gravstrap/%s/%s', $type, $asset);
            $this->grav['assets']->add($assetPath);
        }
    }
}