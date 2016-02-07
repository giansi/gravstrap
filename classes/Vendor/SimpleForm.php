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

namespace Gravstrap\Vendor;

use Gravstrap\Base\BaseShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class SimpleForm defines the shortcode to show the Simple Form object
 *
 * @author Giansimon Diblas
 */
class SimpleForm extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'simple-form';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'vendor/simple_form.html.twig';;
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'token' => $shortcode->getParameter('token'),  
            'redirect_to' => $this->stringToBoolean($shortcode->getParameter('redirect_to')),
            'show_form_labels' => $shortcode->getParameter('show_form_labels'),
        ]);
    }
}
