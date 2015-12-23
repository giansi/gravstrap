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
use \Grav\Common\Page\Page;
use \Grav\Common\Page\Collection;

/**
 * Class ConfigurationParser is the object assigned to parse gravstrap configuration
 *
 * @author Giansimon Diblas
 */
class ConfigurationParser
{
    /**
     * Grav instance
     *
     * @var Grav
     */
    private $grav;

    /**
     * Twig instance
     *
     * @var Twig
     */
    private $twig;

    /**
     * Constructor
     *
     * @param Grav $grav
     */
    public function __construct(Grav $grav)
    {
        $this->grav = $grav;
        $this->twig = $this->grav['twig'];
    }

    /**
    * Parses page configuration to look for gravstrap attributes and sets the gravstrap and gravstrap_collection twig variables.
    *
    * @param string $plugin The plugin to look for the configuration
    * @param string $namespace The plugin classes namespace
    */
    public function parseConfiguration($plugin, $namespace)
    {
        $config = $this->grav["config"]->get('plugins.' . $plugin);

        $gravstrap = array();
        $gravstrapComponents = $this->findPageConfiguration($plugin);
        foreach($gravstrapComponents as $type => $components) {
            $components = $this->configureElement($type, $config, $components, $namespace, $plugin);
            $gravstrap = array_merge_recursive($gravstrap, $this->renderComponents($components, $type));
        }

        if (empty($gravstrap)) {
            return;
        }

        $this->twig->twig_vars[$plugin] = $gravstrap['gravstrap'];
        $this->twig->twig_vars[$plugin . '_collection'] = $gravstrap['collection'];
    }

    private function findPageConfiguration($plugin)
    {
        $gravstrapComponents = array();
        $header = $this->grav["page"]->header();
        if (property_exists($header, $plugin)) {
            $gravstrapComponents = array_merge($header->$plugin, $this->findGravstrapConfigInModules());
        }

        if (array_key_exists($plugin, $this->twig->twig_vars['site'])) {
            $gravstrapComponents = array_merge_recursive($this->twig->twig_vars['site'][$plugin], $gravstrapComponents);
        }

        return $gravstrapComponents;
    }

    private function renderComponents($components, $type)
    {
        $gravstrap = array();
        $sections = $this->twig->twig_vars['sections'];
        $template = sprintf('%s.html.twig', $type);
        foreach($components as $name => $element) {
            if (array_key_exists('from_file', $element)) {
                $element["sections"] = $this->findSection($element, $sections);
            }
            $gravstrap['collection'][$type][] = $gravstrap['gravstrap'][$name] = $this->twig->twig->render($template, array($type => $element));
        }

        return $gravstrap;
    }

    /**
     * Parses page modules to look up for Gravstrap configuration
     *
     * @return array
     */
    private function findGravstrapConfigInModules()
    {
        $collection = $this->grav['page']->collection();
        if (is_array($collection)) {
            return array();
        }

        return $this->parseChildren($collection);
    }

    private function findSection($element, $sections)
    {
        $fileName = $element['from_file'];

        if (array_key_exists($fileName, $sections["page"])) {
            return $sections["page"][$fileName];
        }

        if (!array_key_exists("page", $element)) {
            return array();
        }

        $module = $element["page"]->folder();

        return $sections["modular"][$module][$element['from_file']];
    }

    private function parseChildren(Collection $children)
    {
        $modules = $children->modular();
        if (count($modules) == 0) {
            return array();
        }

        $configurations = array();
        foreach($children as $child) {
            $header = $child->header();
            if (property_exists($header, "gravstrap")) {
                $gravstrapComponents = $this->addModulePageToGravstrap($header->gravstrap, $child);

                $configurations = array_merge($configurations, $gravstrapComponents);
            }
        }

        return $configurations;
    }

    private function addModulePageToGravstrap($configuration, Page $page)
    {
        $gravstrapComponents = array();
        foreach($configuration as $name => $values) {
            foreach($values as $name1 => $value1) {
                $gravstrapComponents[$name][$name1] = array_merge(array(
                    'page' => $page,
                ), $value1);
            }
        }

        return $gravstrapComponents;
    }

    private function configureElement($type, $config, $components, $namespace, $plugin)
    {
        if ( ! array_key_exists($type, $config)) {
            return $components;
        }

        $className = $namespace . "\\" . ucfirst($type);
        if (!class_exists($className)) {
            return array();
        }
        $element = new $className($this->grav, $plugin);
        $element->process($config[$type], $components);

        return $element->processedComponents();
    }
}
