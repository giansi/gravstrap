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

namespace Gravstrap\Bootstrap\Dropdown;

/**
 * Class Dropdown handles a bootstrap splitbutton component
 *
 * @author Giansimon Diblas
 */
class Splitbutton extends Dropdown
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'bootstrap-splitbutton';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'bootstrap/splitbutton.html.twig';
    }
}
