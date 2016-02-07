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
 * Class TeamItem handles a team item
 *
 * @author Giansimon Diblas
 */
class TeamItem extends BaseShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'team-item';
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/team/team_item.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        $this->fetchParentInformation($shortcode);
        $output = $this->grav['twig']->processTemplate($this->template(), [
            'image' => $shortcode->getParameter('image'),   
            'content' => $this->fixContent($shortcode),   
            'socials' => RegisteredShortcodes::get($this->getShortcodeHash($shortcode)),
            'attributes' => $this->parseAttributes($shortcode->getParameter('attributes')),
        ]);
        $this->registerOutput($output);
    }
}
