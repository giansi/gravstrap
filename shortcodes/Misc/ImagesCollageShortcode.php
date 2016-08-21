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

use Grav\Common\Page\Medium\ImageFile;
use Grav\Common\Page\Medium\ImageMedium;
use Grav\Common\Page\Medium\MediumFactory;
use Gregwar\Image\Image;

/**
 * Class ImagesCollageShortcode render a collage of images from a Grav page
 *
 * This shortcode is based on grav-plugin-image-collage (https://github.com/petrgrishin/grav-plugin-image-collage)
 *
 * @author Giansimon Diblas
 */
class ImagesCollageShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-images-collage';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-images-collage' => array(
                'g-images-collage'
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $imagesFolder = $shortcode->getParameter('images-folder');
        is_null($imagesFolder) && $imagesFolder = '/images';
        $page = $this->grav['page']->find($imagesFolder);
        if ($page === null) {
            return "";
        }

        $images = $page->media()->images();
        $columns = $shortcode->getParameter('columns');
        is_null($columns) && $columns = 3;
        $borderSize = $shortcode->getParameter('border-size');
        is_null($borderSize) && $borderSize = 2;
        $width = $shortcode->getParameter('width');
        is_null($width) && $width = 400;
        $attributes = $shortcode->getParameter('attributes');
        $parsedAttributes = array();
        $attributes = explode(',', $attributes);
        foreach($attributes as $attribute) {
            $value = explode(':', $attribute);
            $parsedAttributes[$value[0]] = $value[1];
        }

        return $this->imageCollage($images, $columns, $borderSize, $width, $parsedAttributes);
    }

    /**
     * Credits to petrgrishin (https://github.com/petrgrishin) for this method taken from from his grav-plugin-image-collage (https://github.com/petrgrishin/grav-plugin-image-collage)
     *
     * @param ImageMedium[] $images
     * @param int $column
     * @param int $borderSize
     * @param int $width
     * @param array $attributes
     * @return ImageMedium
     */
    private function imageCollage(array $images , $column, $borderSize, $width, array $attributes = array())
    {
        $widthImg = $width - $borderSize;
        $cachePath = $this->grav['locator']->findResource('cache://images', true);
        $collage = ImageFile::create($widthImg, $widthImg)
            ->setCacheDir($cachePath)
            ->setActualCacheDir($cachePath);
        $collage->rectangle(0, 0, $widthImg, $widthImg, 0xffffff, true);
        $c = 0;
        $r = 0;
        $mergedWidth = $width / $column;
        foreach ($images as $image) {
            $mergedImage = Image::open($image->get('filepath'));
            $mergedImage->zoomCrop($mergedWidth - $borderSize, $mergedWidth - $borderSize);
            $collage->merge($mergedImage, $r * $mergedWidth, $c * $mergedWidth, $mergedWidth - $borderSize, $mergedWidth - $borderSize);
            $c++;
            if ($c % $column == 0) {
                $c = 0;
                $r++;
            }
        }
        $filePath = $collage->cacheFile('jpg', 85);
        $imageMedium = MediumFactory::fromFile($filePath, $attributes);

        return $imageMedium;
    }
}
