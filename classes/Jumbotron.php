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

use Gravstrap\BaseComponent;
use Grav\Common\Grav;

/**
 * Class Jumbotron handles a jumbotron component
 *
 * @author Giansimon Diblas
 */
class Jumbotron extends BaseComponent
{
    /**
     * The Grav images
     *
     * @var array
     */
    private $images = array();

    /**
     * {@inheritdoc}
     */
    public function __construct(Grav $grav, $plugin)
    {
        parent::__construct($grav, $plugin);

        $this->images = $this->grav['page']->media()->images();
    }

    /**
     * {@inheritdoc}
     */
    protected function processComponents(array $components)
    {
        foreach($components as $name => $component) {
            if ( ! array_key_exists('image', $component)) {
                continue;
            }

            $components[$name]["processed_image"] = $this->processImage('image', $component);
        }

        $this->components = $components;
    }

    /**
     * Processes the image, applying the configuration attributes, specified by the given property
     *
     * @param string $propertyName
     * @param array $component
     * @return array
     */
    protected function processImage($propertyName, array $component)
    {
        $properties = $component[$propertyName];
        $imageName = $this->initImage($properties);

        return $this->doImageProcess($imageName, $properties);
    }

    private function initImage($properties)
    {
        $imageName = $properties["name"];
        unset($properties["name"]);

        if (!array_key_exists($imageName, $this->images)) {
            throw new \InvalidArgumentException(sprintf("The image %s has not been found in the current page. Please check the gravstrap header configuration for the %s page.", $imageName, $this->grav['page']->path()));
        }

        return $imageName;
    }

    private function doImageProcess($imageName, $properties)
    {
        $image = $this->images[$imageName];
        foreach($properties as $property => $value) {
            if (!is_array($value)) {
                $value = array($value);
            }

            try{
                call_user_func_array(array($image, $property), $value);
            }
            catch (\Exception $ex) {
                $error = sprintf('The given arguments for "%s" method are wrong. To solve this issue, please check the "jumbotron" configuration in the "%s" page. Generated error: %s',  $property, $this->grav['page']->path(), $ex->getMessage());
                $this->grav['log']->error($error);
            }
        }

        return $image;
    }
}
