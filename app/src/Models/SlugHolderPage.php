<?php

namespace App\Models;

use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use App\Extensions\UrlifyExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Permission;
use App\Controller\SlugHolderPageController;
use SilverStripe\Core\Validation\ValidationResult;

class SlugHolderPage extends SiteTree
{
    private static $db = [
        'ManagedModel' => 'Varchar',
    ];

    private static $controller_name = SlugHolderPageController::class;
    private static $table_name = 'SlugHolderPage';
    private static $description = 'Holder for non-Page objects like JobPostings, Perso, Products';
    private static $allowed_children = [];
    private static $singular_name = 'Slug Holder Page';
    private static $plural_name = 'Slug Holder Pages';
    private static $show_stage_link = false;
    private static $show_live_link = false;

    private static $cms_icon = 'app/images/icon-slugholder.svg';

    private static $defaults = [
        'ShowInMenus' => false,
        'ShowInSearch' => false,
        'HideSubNavi' => true,
    ];

    public function Items()
    {
        $class = $this->ManagedModel;

        return $class && class_exists($class) ? $class::get() : null;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Content',
            'MenuTitle',
            'Metadata',
        ]);

        $managedModelField = DropdownField::create(
            'ManagedModel',
            _t(self::class . '.ManagedModelField', 'Managed model'),
            $this->getAvailableModels(),
        )->setEmptyString(_t(self::class . '.SelectModel', '--'));

        $fields->replaceField('ManagedModel', $managedModelField);

        // Add warning if model is assigned
        if ($this->ManagedModel && class_exists($this->ManagedModel)) {
            $count = $this->Items() ? $this->Items()->count() : 0;
            $modelName = singleton($this->ManagedModel)->i18n_singular_name();
            $message = _t(
                __CLASS__ . '.CannotDeleteWarning',
                'This page serves as a URL segment placeholder.<br/><strong>{count} {model}</strong> items are accessible through it. It cannot be deleted, because otherwise the URLs of these items will no longer be available. To remove it anyway, either unassign the model or delete all items.',
                ['count' => $count, 'model' => $modelName],
            );
            $fields->fieldByName('Root.Main')->unshift(
                LiteralField::create(
                    'CannotDeleteWarning',
                    sprintf('<p class="alert alert-warning">%s</p>', $message),
                ),
            );
        }

        return $fields;
    }

    public function getAvailableModels(): array
    {
        $models = [];
        foreach (ClassInfo::subclassesFor(DataObject::class, false) as $class) {
            if (DataObject::has_extension($class, UrlifyExtension::class)) {
                $models[$class] = singleton($class)->i18n_singular_name() . ' (' . $class . ')';
            }
        }
        asort($models);

        return $models;
    }

    public function canDelete($member = null): bool
    {
        if ($this->ManagedModel && class_exists($this->ManagedModel)) {
            return false;
        }

        return parent::canDelete($member);
    }

    public function canUnpublish($member = null): bool
    {
        if ($this->ManagedModel && class_exists($this->ManagedModel)) {
            return false;
        }

        return parent::canUnpublish($member);
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();
        if ($this->ManagedModel) {
            $duplicate = static::get()
                ->filter('ManagedModel', $this->ManagedModel)
                ->exclude('ID', $this->ID ?: 0)
                ->first();
            if ($duplicate) {
                $result->addError(_t(
                    __CLASS__ . '.DuplicateManagedModel',
                    'A SlugHolderPage for "{model}" already exists.',
                    ['model' => $this->ManagedModel],
                ));
            }
        }

        return $result;
    }

    public function MetaComponents(): array
    {
        $tags = parent::MetaComponents();
        $controller = Controller::curr();
        $item = $controller && $controller->hasMethod('getCurrentItem')
            ? $controller->getCurrentItem()
            : null;

        // Add XML feed link for JobPostings
        if ($this->ManagedModel === 'Kraftausdruck\Models\JobPosting') {
            $tags['alternate:jobs-xml'] = [
                'tag' => 'link',
                'attributes' => [
                    'rel' => 'alternate',
                    'type' => 'application/xml',
                    'href' => '/_jobs.xml',
                    'title' => 'Job Postings Feed',
                ],
            ];
        }

        if ($item) {
            if ($link = $item->AbsoluteLink()) {
                $tags['canonical'] = [
                    'tag' => 'link',
                    'attributes' => ['rel' => 'canonical', 'href' => $link],
                ];
                $tags['og:url'] = [
                    'tag' => 'meta',
                    'attributes' => ['property' => 'og:url', 'content' => $link],
                ];
            }

            if ($title = ($item->MetaTitle ?: $item->DefaultMetaTitle())) {
                $tags['title']['content'] = $title;
                $tags['og:title'] = [
                    'tag' => 'meta',
                    'attributes' => ['property' => 'og:title', 'content' => $title],
                ];
            }

            if ($desc = ($item->MetaDescription ?: $item->DefaultMetaDescription())) {
                $tags['description']['attributes']['content'] = $desc;
                $tags['og:description'] = [
                    'tag' => 'meta',
                    'attributes' => ['property' => 'og:description', 'content' => $desc],
                ];
            }

            if (Permission::check('CMS_ACCESS_CMSMain') && $item->hasMethod('CMSEditLink')) {
                $tags['cmsEditLink']['attributes']['content'] = $item->CMSEditLink();
            }
        }

        return $tags;
    }
}
