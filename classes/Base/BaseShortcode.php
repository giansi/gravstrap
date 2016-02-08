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

use Grav\Common\Grav;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class BaseShortcode defines the base object that handles a Grav shortcode
 *
 * @author Giansimon Diblas
 */
abstract class BaseShortcode implements GravShortcodeInterface
{
    /**
     * Grav instance
     *
     * @var Grav
     */
    protected $grav; 
    
    /**
     * @var ShortcodeInterface 
     */
    private $parentShortcode;
    
    /**
     * @var string
     */
    private $parentHash;
    
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
     * Renders the shortcode output
     */
    abstract protected function renderOutput(ShortcodeInterface $shortcode);
    
    /**
     * Defines the Twig template to render
     */
    abstract protected function template();

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
    public function processShortcode(ShortcodeInterface $shortcode)
    {
        $output = $this->renderShortcode($shortcode);
        if ($output == '') {
            return '';
        }

        $render = (strtolower($shortcode->getParameter('render')) !== 'false') ? true : false;
        if ($render) {
            return $output;
        }

        $id = $shortcode->getParameter('id');
        if (null === $id) {
            return '';
        }
        
        $this->grav['twig']->twig_vars[$id] = $output;
        
        $value = array(
            $id => array(
                "output" => $output,
                'assets' => $this->assets(),
            ),
        );
        $this->saveToCache($value);

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array();
    }
    
    /**
     * Renders the shortcode
     * 
     * @param ShortcodeInterface $shortcode
     * @return string
     */
    protected function renderShortcode(ShortcodeInterface $shortcode)
    {        
        $this->fetchParentInformation($shortcode);
        $output = $this->renderOutput($shortcode);
        if (null === $output) 
        {   return '';
        
        }
        
        $render = (strtolower($shortcode->getParameter('render')) === 'true') ? true : false;
        if (null === $this->parentShortcode() || $render) {
            return $output;
        }
        
        $this->registerOutput($output);
    }

    /**
     * Saves shortcodes to cache
     * 
     * @param array $value
     */
    protected function saveToCache(array $value)
    {
        $cache = $this->grav['cache'];
        $cache_id = md5('gravstrap.shortcodes');
        $shortcodes = $cache->fetch($cache_id);
        if (false === $shortcodes) {
            $shortcodes = array();
        }
        
        $cache->save($cache_id, array_merge($shortcodes, $value));
    }

    /**
     * Fetches the parent and its hash from the given shortcode
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

    /**
     * Returns an unique has for the given shortcode
     * 
     * @param ShortcodeInterface $shortcode
     * @return string
     */
    protected function getShortcodeHash(ShortcodeInterface $shortcode = null)
    {
        if (null === $shortcode) {
            return '';
        }
        
        return substr(md5($shortcode->getShortcodeText()), -10);
    }

    /**
     * Parses attributes given as string and returns an array
     * The given input attributes string is given as a comma separated values string and each keypair combination is separated by a colon. An example is class:my-class,rel=my-rel
     * @param string $tagsString
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function parseAttributes($tagsString)
    {
        $res = array();
        if (null === $tagsString) {
            return $res;
        }

        $tags = explode(',', $tagsString);
        foreach($tags as $tag)
        {
            $tokens = explode(':', $tag);
            if (count($tokens) != 2) {
                throw new \InvalidArgumentException(sprintf('The attribute "%s" provided for the "%s" shortcode is not valid'   , $tagsString, $this->shortcode()));
            }

            $res[$tokens[0]] = $tokens[1];
        }

        return $res;
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
        if ($value == 'true') {
            return true;
        }

        return false;
    }
}
