<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Twitter\Icons
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */

namespace SilverWare\Twitter\Icons;

use SilverWare\Social\Model\SharingIcon;
use SilverWare\Twitter\Buttons\TwitterSharingButton;

/**
 * An extension of the sharing icon class for a Twitter sharing icon.
 *
 * @package SilverWare\Twitter\Icons
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */
class TwitterSharingIcon extends SharingIcon
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Twitter Sharing Icon';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Twitter Sharing Icons';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A sharing icon to share the current page via Twitter';
    
    /**
     * Defines the table name to use for this object.
     *
     * @var string
     * @config
     */
    private static $table_name = 'SilverWare_TwitterSharingIcon';
    
    /**
     * Defines an ancestor class to hide from the admin interface.
     *
     * @var string
     * @config
     */
    private static $hide_ancestor = SharingIcon::class;
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'FontIcon' => 'twitter',
        'ColorBackgroundLink' => '#3abeff',
        'ColorForegroundLink' => '#ffffff'
    ];
    
    /**
     * Defines the class of sharing button to use for the popover.
     *
     * @var string
     * @config
     */
    private static $button_class = TwitterSharingButton::class;
}
