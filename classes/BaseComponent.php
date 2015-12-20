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

use Grav\Common\Grav;
use Gravstrap\ComponentInterface;

/**
 * Class BaseComponent defines the base object that handles a Bootstrap component
 *
 * @author Giansimon Diblas
 */
abstract class BaseComponent implements ComponentInterface
{
    /**
     * Grav instance
     *
     * @var Grav
     */
    protected $grav;

    /**
     * Component configuration
     *
     * @var array
     */
    protected $config;

    /**
     * The processed components
     *
     * @var array
     */
    protected $components;

    /**
     * The current plugin name
     *
     * @var string
     */
    private $plugin;

    /**
     * Constructor
     *
     * @param Grav $grav
     * @param $plugin
     */
    public function __construct(Grav $grav, $plugin)
    {
        $this->grav = $grav;
        $this->plugin = $plugin;
    }

    /**
     * {@inheritdoc}
     */
    public function process(array $config, array $components)
    {
        $this->config = $config;
        $this->processComponents($components);
        if ( ! $this->config["enhanced"]) {
            return;
        }

        $this->addAssets();
    }

    /**
     * {@inheritdoc}
     */
    public function processedComponents()
    {
        return $this->components;
    }

    /**
     * Processes the component items
     *
     * @return array
     */
    protected function processComponents(array $components)
    {
        $this->components = $components;
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
            $assetPath = sprintf('plugin://%s/%s/%s', $this->plugin, $type, $asset);
            $this->grav['assets']->add($assetPath);
        }
    }
}
