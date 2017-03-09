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
 * Class PortfolioShortcode handles a module to show a bootstrap thumbnails portfolio
 *
 * @author Giansimon Diblas
 */
class GravstrapPortfolioShortcode extends GravstrapShortcode
{    
    /**
     * {@inheritdoc}
     */
    protected function shortcodeName()
    {
        return 'gravstrap-portfolio';
    }
    
    /**
     * {@inheritdoc}
     */
    public function assets()
    {
        return array(  
            'css' => array(          
                'plugin://gravstrap/css/gravstrap_portfolio.css',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function template()
    {
        return 'modules/portfolio.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function aliases()
    {
        return array(
            'g-portfolio',
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderOutput(ShortcodeInterface $shortcode)
    {
        return $this->twig->processTemplate($this->template(), [
            'name' => $shortcode->getParameter('name'),
            'content' => $this->fixContent($shortcode),   
            'items' => $this->shortcode->getStates($this->shortcode->getId($shortcode)),   
            'attributes' => $shortcode->getParameter('attributes'), 
            'column_attributes' => $shortcode->getParameter('column_attributes'), 
        ]);
    }
}