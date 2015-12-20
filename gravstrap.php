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

use \Grav\Common\Plugin;
use \Composer\Autoload\ClassLoader;
use \Gravstrap\ConfigurationParser;

class GravstrapPlugin extends Plugin
{
    private $loader = null;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        $this->enable([
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->autoload('Gravstrap', array(__DIR__ . '/classes'));
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Configures Gravstrap
     */
    public function onTwigSiteVariables()
    {
        $configurationParser = new ConfigurationParser($this->grav);
        $configurationParser->parseConfiguration('gravstrap', 'Gravstrap');
    }

    protected function autoload($namespace, $folders)
    {
        if ($this->loader === null) {
            $this->loader = new ClassLoader();
        }

        $this->loader->setPsr4($namespace . '\\', $folders);
        $this->loader->register(true);
    }
}
