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

require_once (__DIR__ . '/BaseComponent.php');

/**
 * Class Jumbotron handles a jumbotron component
 *
 * @author Giansimon Diblas
 */
class Jumbotron extends BaseComponent
{
    /**
     * {@inheritdoc}
     */
    protected function processComponents(array $components)
    {
        foreach($components as $name => $component) {
            if ( ! array_key_exists('image', $component)) {
                continue;
            }
            
            $imageProperties = $component['image'];
            $imageName = $imageProperties["name"];
            unset($imageProperties["name"]);
            
            $image = $this->grav['page']->media()->images()[$imageName];
            foreach($imageProperties as $property => $value) {
                if (!is_array($value)) {
                    $value = array($value);
                }
                
                try{
                    call_user_func_array(array($image, $property), $value);
                } catch (\Exception $ex) {
                    $error = sprintf('The given arguments for "%s" method are wrong. To solve this issue, please check the "jumbotronic" configuration in the "%s" page. Generated error: %s',  $property, $this->grav['page']->path(), $ex->getMessage());
                    $this->grav['log']->error($error);
                }
            }

            $components[$name]["processed_image"] = $image;  
        }
        
        $this->components = $components;
    }
    
}