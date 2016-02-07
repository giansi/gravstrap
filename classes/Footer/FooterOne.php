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

use Gravstrap\Base\BaseSectionShortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

/**
 * Class FooterOne handles a basic footer module
 *
 * @author Giansimon Diblas
 */
class FooterOne extends BaseSectionShortcode
{
    /**
     * {@inheritdoc}
     */
    public function shortcode()
    {
        return 'footer-one';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(            
            'plugin://gravstrap/css/gravstrap_footer.css',            
            'plugin://gravstrap/css/gravstrap_footer_inline_navigation.css',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/footer/footer_one.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->grav['twig']->processTemplate($this->template(), [
            'sections' => $this->sections($shortcode),
        ]);
    }
}
