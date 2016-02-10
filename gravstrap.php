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
use Composer\Autoload\ClassLoader;
use RocketTheme\Toolbox\Event\Event;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class GravstrapPlugin extends Plugin
{
    /**
     * HandlersCollection instance
     * 
     * @var HandlersCollection 
     */
    protected $handlers;

    /**
     * ClassLoader instance
     *
     * @var ClassLoader
     */
    private $loader = null;
    
    /** @var  AssetContainer $assets */
    protected $assets;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
        ];
    }

    /**
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        $this->enable([
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        ]);
    }

    /**
     * Initializes the shortcodes
     * 
     * @param Event $e
     */
    public function onShortcodeHandlers(Event $e)
    {
        $this->handlers = $e['handlers'];
        $this->assets = $e['assets'];

        $namespace = 'Gravstrap';
        $directory = __DIR__ . '/classes';
        $this->autoload($namespace, array($directory));        
        $this->registerShortcodes($namespace, $directory);
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates/modules';
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates/components';
    }

    /**
     * Configures Gravstrap
     */
    public function onTwigSiteVariables()
    {
        $sectionsName = 'sections' . $this->grav['page']->folder();
        $cache = $this->grav['cache'];
        $cache_id = md5('gravstrap.shortcodes');
        $shortcodes = $cache->fetch($cache_id);
        if (false !== $shortcodes) {
            foreach($shortcodes as $id => $value) {
                $variableName = $id;
                if ($id == $sectionsName) {
                    $variableName = 'sections';
                }
                $this->grav['twig']->twig_vars[$variableName] = $value["output"];
                $this->grav["assets"]->add($value["assets"]);
            }
        }
                
        $page = $this->grav['page']->find('/common');
        if (null === $page) {
            return;
        }
            
        $page->content();
    }
    
    protected function registerShortcodes($namespace, $directory)
    {
        $files = $this->scanDirRecursive($directory);
        foreach($files as $file) {
            $file = str_replace($directory . '/', '', $file);
            $file = str_replace('/', '\\', $file);
            $class = $namespace . '\\' . str_replace('.php', '', $file);
            // Make sure to initialize only objects that implements the GravShortcodeInterface
            if (!in_array('Gravstrap\\Base\\GravShortcodeInterface', class_implements($class))) {
                continue;
            }
            
            // Excludes abstract classes and interfaces
            $reflectionClass = new \ReflectionClass($class);
            if(!$reflectionClass->IsInstantiable()) {
                continue;
            }
            
            $this->registerShortcode($class);
        }
    }

    /**
     * Registers the shortcode
     * 
     * @param string $className
     */
    protected function registerShortcode($className)
    {
        $class = new \ReflectionClass($className);
        $shortcodeObject = $class->newInstanceArgs(array($this->grav));
        
        foreach($shortcodeObject->assets() as $type => $assets) {
            foreach($assets as $asset) {
                $this->grav['shortcode']->addAssets($type, $asset);
            }
        }
        
        $this->grav['shortcode']->getHandlers()->add($shortcodeObject->shortcode(), function(ShortcodeInterface $shortcode) use($shortcodeObject) {
            return $shortcodeObject->processShortcode($shortcode);
        });
    }

    /**
     * Scans a directory recursively and returns files found
     * 
     * @param string $dir
     * @param array $allowedExtensions
     * @return array
     */
    protected function scanDirRecursive($dir, $allowedExtensions = array('php'))
    {
        $files = array();
        $dh  = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            $filePath = $dir . '/' . $filename;
            if ($filename != '.' && $filename != '..' && is_dir($filePath)) {
                $files = array_merge($files, $this->scanDirRecursive($filePath));

                continue;
            }
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if ( ! in_array($ext, $allowedExtensions)) {
                continue;
            }

            $files[] = $filePath;
        }

        return $files;
    }

    /**
     * Autoloads a namespace, parsing the given folders
     *
     * @param string $namespace
     * @param array $folders
     */
    protected function autoload($namespace, array $folders)
    {
        if ($this->loader === null) {
            $this->loader = new ClassLoader();
        }

        $this->loader->setPsr4($namespace . '\\', $folders);
        $this->loader->register(true);
    }
}
