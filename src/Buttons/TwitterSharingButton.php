<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Twitter\Buttons
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */

namespace SilverWare\Twitter\Buttons;

use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\DropdownField;
use SilverWare\Social\Model\SharingButton;

/**
 * An extension of the sharing button class for a Twitter sharing button.
 *
 * @package SilverWare\Twitter\Buttons
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */
class TwitterSharingButton extends SharingButton
{
    /**
     * Define size constants.
     */
    const SIZE_DEFAULT = 'default';
    const SIZE_LARGE   = 'large';
    
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Twitter Sharing Button';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Twitter Sharing Buttons';
    
    /**
     * Defines an ancestor class to hide from the admin interface.
     *
     * @var string
     * @config
     */
    private static $hide_ancestor = SharingButton::class;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'ButtonSize' => 'Varchar(16)'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'ButtonSize' => 'default'
    ];
    
    /**
     * Defines the link href for the sharing button.
     *
     * @var string
     * @config
     */
    private static $link_href = 'https://twitter.com/intent/tweet';
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Create Style Fields:
        
        $fields->addFieldToTab(
            'Root.Style',
            CompositeField::create([
                DropdownField::create(
                    'ButtonSize',
                    $this->fieldLabel('ButtonSize'),
                    $this->getButtonSizeOptions()
                )
            ])->setName('TwitterSharingButtonStyle')->setTitle($this->i18n_singular_name())
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the labels for the fields of the receiver.
     *
     * @param boolean $includerelations Include labels for relations.
     *
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        // Obtain Field Labels (from parent):
        
        $labels = parent::fieldLabels($includerelations);
        
        // Define Field Labels:
        
        $labels['ButtonSize'] = _t(__CLASS__ . '.BUTTONSIZE', 'Button size');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Populates the default values for the fields of the receiver.
     *
     * @return void
     */
    public function populateDefaults()
    {
        // Populate Defaults (from parent):
        
        parent::populateDefaults();
        
        // Populate Defaults:
        
        $this->Name = _t(__CLASS__ . '.SHAREVIATWITTER', 'Share via Twitter');
    }
    
    /**
     * Answers an array of link class names for the HTML template.
     *
     * @return array
     */
    public function getLinkClassNames()
    {
        $classes = ['twitter-share-button'];
        
        $this->extend('updateLinkClassNames', $classes);
        
        return $classes;
    }
    
    /**
     * Answers the link for the sharing button.
     *
     * @todo Add via / hashtag params to link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->config()->link_href;
    }
    
    /**
     * Answers an array of options for the button size field.
     *
     * @return array
     */
    public function getButtonSizeOptions()
    {
        return [
            self::SIZE_DEFAULT => _t(__CLASS__ . '.DEFAULT', 'Default'),
            self::SIZE_LARGE => _t(__CLASS__ . '.LARGE', 'Large')
        ];
    }
}
