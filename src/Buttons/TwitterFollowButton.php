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
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */

namespace SilverWare\Twitter\Buttons;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverWare\Components\BaseComponent;
use SilverWare\Forms\FieldSection;

/**
 * An extension of the base component class for a Twitter follow button.
 *
 * @package SilverWare\Twitter\Buttons
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */
class TwitterFollowButton extends BaseComponent
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
    private static $singular_name = 'Twitter Follow Button';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Twitter Follow Buttons';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A component which shows a Twitter follow button';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/twitter: admin/client/dist/images/icons/TwitterFollowButton.png';
    
    /**
     * Defines the table name to use for this object.
     *
     * @var string
     * @config
     */
    private static $table_name = 'SilverWare_TwitterFollowButton';
    
    /**
     * Defines an ancestor class to hide from the admin interface.
     *
     * @var string
     * @config
     */
    private static $hide_ancestor = BaseComponent::class;
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = 'none';
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'Username' => 'Varchar(32)',
        'Size' => 'Varchar(16)',
        'ShowCount' => 'Boolean',
        'ShowUsername' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'Size' => self::SIZE_DEFAULT,
        'ShowCount' => 1,
        'ShowUsername' => 1
    ];
    
    /**
     * Maps field and method names to the class names of casting objects.
     *
     * @var array
     * @config
     */
    private static $casting = [
        'LinkAttributesHTML' => 'HTMLFragment'
    ];
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Define Placeholders:
        
        $placeholderAuto = _t(__CLASS__ . '.DROPDOWNAUTOMATIC', 'Automatic');
        
        // Create Main Fields:
        
        $fields->addFieldsToTab(
            'Root.Main',
            [
                TextField::create(
                    'Username',
                    $this->fieldLabel('Username')
                )
            ]
        );
        
        // Create Style Fields:
        
        $fields->addFieldToTab(
            'Root.Style',
            FieldSection::create(
                'ButtonStyle',
                $this->fieldLabel('ButtonStyle'),
                [
                    DropdownField::create(
                        'Size',
                        $this->fieldLabel('Size'),
                        $this->getSizeOptions()
                    )
                ]
            )
        );
        
        // Create Options Fields:
        
        $fields->addFieldToTab(
            'Root.Options',
            FieldSection::create(
                'ButtonOptions',
                $this->fieldLabel('ButtonOptions'),
                [
                    CheckboxField::create(
                        'ShowCount',
                        $this->fieldLabel('ShowCount')
                    ),
                    CheckboxField::create(
                        'ShowUsername',
                        $this->fieldLabel('ShowUsername')
                    )
                ]
            )
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers a validator for the CMS interface.
     *
     * @return RequiredFields
     */
    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Username'
        ]);
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
        
        $labels['Size'] = _t(__CLASS__ . '.SIZE', 'Size');
        $labels['Username'] = _t(__CLASS__ . '.USERNAME', 'Username');
        $labels['ShowCount'] = _t(__CLASS__ . '.SHOWCOUNT', 'Show count');
        $labels['ShowUsername'] = _t(__CLASS__ . '.SHOWUSERNAME', 'Show username');
        $labels['ButtonStyle'] = $labels['ButtonOptions'] = _t(__CLASS__ . '.BUTTON', 'Button');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Event method called before the receiver is written to the database.
     *
     * @return void
     */
    public function onBeforeWrite()
    {
        // Call Parent Event:
        
        parent::onBeforeWrite();
        
        // Sanitise Fields:
        
        $this->Username = ltrim(trim($this->Username), '@');
    }
    
    /**
     * Answers an array of attributes for the link.
     *
     * @return array
     */
    public function getLinkAttributes()
    {
        $attributes = [
            'class' => 'twitter-follow-button',
            'href' => $this->getLinkURL()
        ];
        
        $this->extend('updateLinkAttributes', $attributes);
        
        $attributes = array_merge($attributes, $this->getLinkDataAttributes());
        
        return $attributes;
    }
    
    /**
     * Answers an array of data attributes for the link.
     *
     * @return array
     */
    public function getLinkDataAttributes()
    {
        $attributes = [];
        
        if ($this->Size !== self::SIZE_DEFAULT) {
            $attributes['data-size'] = $this->Size;
        }
        
        if (!$this->ShowCount) {
            $attributes['data-show-count'] = 'false';
        }
        
        if (!$this->ShowUsername) {
            $attributes['data-show-screen-name'] = 'false';
        }
        
        $this->extend('updateLinkDataAttributes', $attributes);
        
        return $attributes;
    }
    
    /**
     * Answers a string of attributes for the link.
     *
     * @return string
     */
    public function getLinkAttributesHTML()
    {
        return $this->getAttributesHTML($this->getLinkAttributes());
    }
    
    /**
     * Answers the link URL for the receiver.
     *
     * @return string
     */
    public function getLinkURL()
    {
        return sprintf('https://twitter.com/%s', $this->Username);
    }
    
    /**
     * Answers the text for the link in the template.
     *
     * @return string
     */
    public function getText()
    {
        return sprintf(_t(__CLASS__ . '.FOLLOWUSERNAME', 'Follow %s'), $this->Username);
    }
    
    /**
     * Answers true if the object is disabled within the template.
     *
     * @return boolean
     */
    public function isDisabled()
    {
        if (!$this->Username) {
            return true;
        }
        
        return parent::isDisabled();
    }
    
    /**
     * Answers an array of options for the size field.
     *
     * @return array
     */
    public function getSizeOptions()
    {
        return [
            self::SIZE_DEFAULT => _t(__CLASS__ . '.DEFAULT', 'Default'),
            self::SIZE_LARGE   => _t(__CLASS__ . '.LARGE', 'Large')
        ];
    }
}
