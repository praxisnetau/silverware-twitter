<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Twitter\Components
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */

namespace SilverWare\Twitter\Components;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayLib;
use SilverWare\Components\BaseComponent;
use SilverWare\Forms\FieldSection;

/**
 * An extension of the base component class for a Twitter timeline widget.
 *
 * @package SilverWare\Twitter\Components
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-twitter
 */
class TwitterTimelineWidget extends BaseComponent
{
    /**
     * Define theme constants.
     */
    const THEME_DARK  = 'dark';
    const THEME_LIGHT = 'light';
    
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Twitter Timeline';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Twitter Timelines';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A component which shows a Twitter timeline';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware-twitter/admin/client/dist/images/icons/TwitterTimelineWidget.png';
    
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
        'Theme' => 'Varchar(16)',
        'Width' => 'AbsoluteInt',
        'Height' => 'AbsoluteInt',
        'Language' => 'Varchar(8)',
        'NumberOfTweets' => 'AbsoluteInt',
        'HideHeader' => 'Boolean',
        'HideFooter' => 'Boolean',
        'HideBorders' => 'Boolean',
        'HideScrollbar' => 'Boolean',
        'Transparent' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'Theme' => 'light',
        'Language' => 'en',
        'HideHeader' => 0,
        'HideFooter' => 0,
        'HideBorders' => 0,
        'HideScrollbar' => 0,
        'Transparent' => 0
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
                'WidgetStyle',
                $this->fieldLabel('WidgetStyle'),
                [
                    DropdownField::create(
                        'Theme',
                        $this->fieldLabel('Theme'),
                        $this->getThemeOptions()
                    ),
                    TextField::create(
                        'Width',
                        $this->fieldLabel('Width')
                    ),
                    TextField::create(
                        'Height',
                        $this->fieldLabel('Height')
                    )
                ]
            )
        );
        
        // Create Options Fields:
        
        $fields->addFieldToTab(
            'Root.Options',
            FieldSection::create(
                'WidgetOptions',
                $this->fieldLabel('WidgetOptions'),
                [
                    DropdownField::create(
                        'NumberOfTweets',
                        $this->fieldLabel('NumberOfTweets'),
                        $this->getNumberOfTweetsOptions()
                    )->setEmptyString(' ')->setAttribute('data-placeholder', $placeholderAuto),
                    DropdownField::create(
                        'Language',
                        $this->fieldLabel('Language'),
                        $this->getLanguageOptions()
                    )->setEmptyString(' ')->setAttribute('data-placeholder', $placeholderAuto),
                    CheckboxField::create(
                        'HideHeader',
                        $this->fieldLabel('HideHeader')
                    ),
                    CheckboxField::create(
                        'HideFooter',
                        $this->fieldLabel('HideFooter')
                    ),
                    CheckboxField::create(
                        'HideBorders',
                        $this->fieldLabel('HideBorders')
                    ),
                    CheckboxField::create(
                        'HideScrollbar',
                        $this->fieldLabel('HideScrollbar')
                    ),
                    CheckboxField::create(
                        'Transparent',
                        $this->fieldLabel('Transparent')
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
        
        $labels['Width'] = _t(__CLASS__ . '.WIDTHINPIXELS', 'Width (in pixels)');
        $labels['Height'] = _t(__CLASS__ . '.HEIGHTINPIXELS', 'Height (in pixels)');
        $labels['Username'] = _t(__CLASS__ . '.USERNAME', 'Username');
        $labels['Language'] = _t(__CLASS__ . '.LANGUAGE', 'Language');
        $labels['HideHeader'] = _t(__CLASS__ . '.HIDEHEADER', 'Hide header');
        $labels['HideFooter'] = _t(__CLASS__ . '.HIDEFOOTER', 'Hide footer');
        $labels['HideBorders'] = _t(__CLASS__ . '.HIDEBORDERS', 'Hide borders');
        $labels['HideScrollbar'] = _t(__CLASS__ . '.HIDEHEADER', 'Hide scrollbar');
        $labels['NumberOfTweets'] = _t(__CLASS__ . '.NUMBEROFTWEETS', 'Number of tweets');
        $labels['Transparent'] = _t(__CLASS__ . '.TRANSPARENT', 'Transparent');
        $labels['WidgetStyle'] = $labels['WidgetOptions'] = _t(__CLASS__ . '.WIDGET', 'Widget');
        
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
            'class' => 'twitter-timeline',
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
        $attributes = ['data-theme' => $this->Theme];
        
        if ($this->Width) {
            $attributes['data-width'] = $this->Width;
        }
        
        if ($this->Height) {
            $attributes['data-height'] = $this->Height;
        }
        
        if ($this->Chrome) {
            $attributes['data-chrome'] = $this->Chrome;
        }
        
        if ($this->Language) {
            $attributes['data-lang'] = $this->Language;
        }
        
        if ($this->NumberOfTweets) {
            $attributes['data-tweet-limit'] = $this->NumberOfTweets;
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
        return sprintf(_t(__CLASS__ . '.TWEETSBYUSERNAME', 'Tweets by %s'), $this->Username);
    }
    
    /**
     * Answers the value for the widget chrome attribute.
     *
     * @return string
     */
    public function getChrome()
    {
        $chrome = [];
        
        if ($this->HideHeader) {
            $chrome[] = 'noheader';
        }
        
        if ($this->HideFooter) {
            $chrome[] = 'nofooter';
        }
        
        if ($this->HideBorders) {
            $chrome[] = 'noborders';
        }
        
        if ($this->HideScrollbar) {
            $chrome[] = 'noscrollbar';
        }
        
        if ($this->Transparent) {
            $chrome[] = 'transparent';
        }
        
        return implode(' ', $chrome);
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
     * Answers an array of options for the theme field.
     *
     * @return array
     */
    public function getThemeOptions()
    {
        return [
            self::THEME_LIGHT => _t(__CLASS__ . '.LIGHT', 'Light'),
            self::THEME_DARK => _t(__CLASS__ . '.DARK', 'Dark')
        ];
    }
    
    /**
     * Answers an array of options for the number of tweets field.
     *
     * @return array
     */
    public function getNumberOfTweetsOptions()
    {
        return ArrayLib::valuekey(range(1, 20));
    }
    
    /**
     * Answers an array of options for the language field.
     *
     * @return array
     */
    public function getLanguageOptions()
    {
        return $this->getSiteConfig()->config()->twitter_languages;
    }
}
