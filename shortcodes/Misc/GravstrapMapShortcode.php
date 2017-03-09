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

/**
 * Class MapShortcode handles a google map component
 *
 * @author Giansimon Diblas
 */
class GravstrapMapShortcode extends GravstrapShortcode
{
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-map';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'misc/map.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function childrenShortcodes()
    {
        return array(
            'gravstrap-map-marker'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(
            'css' => array(
                'plugin://gravstrap/css/gravstrap_googlemap.css',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'gravstrap-map' => array(
                'g-map'
            ),
            'gravstrap-map-marker' => array(
                'g-map-marker'
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'id' => $shortcode->getParameter('id'),
            'zoom' => $shortcode->getParameter('zoom'),
            'center' => $this->convertChoords($shortcode->getParameter('center')),
            'markers' => $this->markers($shortcode),
            'api_key' => $shortcode->getParameter('api-key'),
        ]);
    }

    private function markers(ShortcodeInterface $parentShortcode)
    {
        $markers = array();
        $shortcodes = $this->shortcode->getStates($this->shortcode->getId($parentShortcode));
        foreach($shortcodes as $shortcode) {
            $markers[] = array(
                'location' => $this->convertChoords($shortcode->getParameter('location')),
                'title' => $shortcode->getParameter('title'),
                'info' => preg_replace('/[\n,\r]/s', '', $this->arrangeContent($shortcode->getContent())),
            );
        }

        return $markers;
    }

    private function convertChoords($value)
    {
        return json_encode(array_combine(array('lat', 'lng'), explode(",", $value)), JSON_NUMERIC_CHECK);
    }

    private function arrangeContent($content)
    {
        $content = trim($content);
        $content = preg_replace('/(^[\n,\r])/s', '', $content);
        $content = preg_replace('/($[\n,\r])/s', '', $content);
        $content = nl2br($content);
        $content = preg_replace('/([\n,\r])/s', '', $content);

        return $content;
    }
}
