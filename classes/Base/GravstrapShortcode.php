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

namespace Grav\Plugin\Shortcodes;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Gravstrap\Base\RegisteredShortcodes;

/**
 * Class GravstrapShortcode extends the core Shortcode object, extending its functionalities.
 *
 * @author Giansimon Diblas
 */
abstract class GravstrapShortcode extends Shortcode
{
    /**
     * Returns the sortcode tag name
     *
     * @return string
     */
    abstract protected function shortcodeName();

    /**
     * Returns the name of the template to use
     *
     * @return string
     */
    abstract protected function template();

    /**
     * Renders the shortcode output
     *
     * @param ShortcodeInterface $shortcode
     * @return string
     */
    abstract protected function renderOutput(ShortcodeInterface $shortcode);

    /**
     * Initializes the shortcode
     */
    public function init()
    {
        $this->shortcode->getHandlers()->add($this->shortcodeName(), function(ShortcodeInterface $shortcode) {

            foreach($this->assets() as $type => $assets) {
                foreach($assets as $asset) {
                    $this->shortcode->addAssets($type, $asset);
                }
            }

            $output = $this->renderOutput($shortcode);
            if (null !== $shortcode->getParent()) {
                $this->registerOutput($shortcode, $output);
            }

            if (strtolower($shortcode->getParameter('render')) == "false") {
                $this->registerSection($shortcode, $output);

                return;
            }

            return $output;
        });

        foreach($this->childrenShortcodes() as $childShortcode) {
            $this->registerChildShortcode($childShortcode);
        }

        foreach($this->aliases() as $aliasShortcode => $alias) {
            if (!is_array($alias)) {
                $this->shortcode->getHandlers()->addAlias($alias, $this->shortcodeName());

                continue;
            }

            foreach($alias as  $aliasName) {
                $this->shortcode->getHandlers()->addAlias($aliasName, $aliasShortcode);
            }
        }
    }

    /**
     * Add aliases to shortcode.
     *
     * Aliases can be defined as follows:
     *
     * array(
            'g-jumbotron',
        );
     *
     * or
     *
     * array(
            'gravstrap-accordion' => array(
                'g-accordion'
            ),
            'gravstrap-accordion-item' => array(
                'g-accordion-item'
            ),
        );
     *
     *
     * @return array
     */
    protected function aliases()
    {
        return array();
    }

    /**
     * Initializes children shortcodes.
     *
     * @see Grav\Plugin\Shortcodes\CarouselShortcode
     * @return array
     */
    protected function childrenShortcodes()
    {
        return array();
    }

    /**
     * Add extra assets required by the shortcode.
     *
     * An example could be the following one:
     * return array(
            'css' => array(
                'plugin://gravstrap/css/gravstrap_progressbar.css',
            ),
            'js' => array(
                'plugin://gravstrap/js/gravstrap_navbar.js',
                'plugin://gravstrap/js/scroll.js',
            ),
        );
     *
     * @return array
     */
    protected function assets()
    {
        return array();
    }

    /**
     * Looks for a parameter in the given shortcode first, then looks to its parent when it is not found
     *
     * @param ShortcodeInterface $shortcode
     * @param string $parameterName
     * @param ShortcodeInterface $parent
     * @return mixed s$value
     */
    protected function findParameterInCascade(ShortcodeInterface $shortcode, $parameterName, ShortcodeInterface $parent = null)
    {
        if (null === $parent) {
            $parent = $shortcode->getParent();
        }

        $value = $shortcode->getParameter($parameterName);
        if (null === $value && null !== $parent) {
            $value = $parent->getParameter($parameterName);
        }

        return $value;
    }

    /**
     * Parses Gravstrap shortcode sections
     */
    protected function sections(ShortcodeInterface $shortcode)
    {
        $items = array();
        $registeredItems = RegisteredShortcodes::get($this->shortcode->getId($shortcode));
        foreach ($registeredItems as $value) {
            if (!is_array($value)) {
                continue;
            }
            $name = key($value);
            $items[$name] = $value[$name];
        }

        return $items;
    }

    /**
     * Registers the given output for the handled shortcode parent
     *
     * @param mixed $output
     */
    protected function registerOutput($shortcode, $output)
    {
        $parentShortcode = $shortcode->getParent();
        $parentHash = $this->shortcode->getId($parentShortcode);

        RegisteredShortcodes::register($parentHash, $output);
    }

    /**
     * Register a shortcode section
     *
     * @param ShortcodeInterface $shortcode
     * @param strign|null $content
     */
    protected function registerSection(ShortcodeInterface $shortcode, $content = null)
    {
        if (null === $content) {
            $content = $shortcode->getContent();
        }

        $name = $shortcode->getParameter('name');
        $object = new ShortcodeObject($name, $content);
        $this->shortcode->addObject($shortcode->getName(), $object);
    }

    /**
     * Registers a child shortcode
     *
     * @param string $shortcodeName
     */
    protected function registerChildShortcode($shortcodeName)
    {
        $this->shortcode->getHandlers()->add($shortcodeName, function(ShortcodeInterface $shortcode) {
            if (null === $shortcode->getParent()) {
                return;
            }

            $hash = $this->shortcode->getId($shortcode->getParent());
            $this->shortcode->setStates($hash, $shortcode);

            return;
        });
    }

    /**
     * Returns the given default value when given value is null
     *
     * @param mixed $value
     * @param mixed $default
     * @return mixed
     */
    protected function defaultValue($value, $default)
    {
        return (null !== $value) ? $value : $default;
    }

    /**
     * Fixes the shortcode content
     *
     * @param ShortcodeInterface $shortcode
     * @return type
     */
    protected function fixContent(ShortcodeInterface $shortcode)
    {
        $content = preg_replace('/(^\<\/p\>\s)/is', '', $shortcode->getContent());

        return trim(preg_replace('/(\<p\>$)/is', '', $content));
    }

    /**
     * Converts a string to boolean
     *
     * @param string $value
     * @return boolean
     */
    protected function stringToBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
