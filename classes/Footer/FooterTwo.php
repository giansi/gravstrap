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

namespace Gravstrap\Footer;


/**
 * Class FooterTwo handles a basic footer module with license
 *
 * @author Giansimon Diblas
 */
class FooterTwo extends FooterOne
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'footer-two';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/footer/footer_two.html.twig';
    }
}
