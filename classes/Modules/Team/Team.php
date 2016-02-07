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

namespace Gravstrap\Modules\Team;

use Gravstrap\Base\BaseShortcode;
use Gravstrap\Base\RegisteredShortcodes;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class Team handles a module to show a list of team members
 *
 * @author Giansimon Diblas
 */
class Team extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/team/team.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [    
            'content' => $this->fixContent($shortcode),   
            'items' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),   
            'id' => $shortcode->getParameter('id'),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')), 
            'column_attributes' => $this->parseAttributes($shortcode->getParameter('column_attributes')), 
        ]);
    }
}
