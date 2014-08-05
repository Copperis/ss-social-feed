<?php

/**
 * Milkyway Multimedia
 * SocialFeed_Page.php
 *
 * @package reggardocolaianni.com
 * @author Mellisa Hankins <mell@milkywaymultimedia.com.au>
 */
class SocialFeed_Page extends SocialFeed_Profile {

    private static $singular_name = 'Children of Page';

    private static $db = [
        'Author'         => 'Varchar',
        'AllowPageLikes' => 'Boolean',
        'AllowPostLikes' => 'Boolean',
    ];

    private static $has_one = [
        'Page' => 'Page',
    ];

    protected $provider = 'Milkyway\SS\SocialFeed\Providers\SS_Page';

    public function getCMSFields() {
        $this->beforeExtending('updateCMSFields', function(FieldList $fields) {
                $fields->replaceField('PageID', TreeDropdownField::create('PageID', _t('SocialFeed.DISPLAY_CHILDREN_OF_PAGE', 'Page'), 'Page'));
            }
        );

        $fields = parent::getCMSFields();
        return $fields;
    }

    public function getTitle()
    {
        return $this->Page()->Title;
    }

    public function getFeedSettings() {
        return [
            'page' => $this->Page(),
            'limit' => $this->Limit,
        ];
    }

    public function getPostSettings() {
        return array_merge(parent::getPostSettings(), [
                'canLikePage' => $this->AllowPageLikes,
                'canLikePost' => $this->AllowPostLikes,
            ]);
    }

    public function getPlatform() {
        return _t('SocialFeed.CHILDREN_OF_PAGE', 'Children of \'{page}\' ({type})', ['page' => $this->Page()->Title, 'type' => $this->Page()->i18n_singular_name()]);
    }

    public function Link() {
        return $this->Page()->AbsoluteLink;
    }

    public function LikeButton($url = '') {
        if(!$url)
            $url = $this->Link();

        return $this->customise(['fbLink' => $url])->renderWith('Facebook_LikeButton');
    }

    public function LikePostButton($url = '') {
        return $this->LikeButton($url);
    }
}