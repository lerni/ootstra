<?php

namespace App\Extensions;

use SilverStripe\Forms\Form;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Core\Injector\Injector;
use Wilr\SilverStripe\Algolia\Service\AlgoliaQuerier;

class AlgoliaControllerExtension extends Extension {

    private static $allowed_actions = [
        'SearchForm',
        'Results'
    ];

    public function SearchForm()
    {
        $search_query = ($this->getOwner()->request && $this->getOwner()->request->requestVar('Search')) ?
                        $this->getOwner()->request->requestVar('Search') : 'Suchen';
        $search_query = Convert::raw2sql($search_query);
        $form = new Form(
            $this->getOwner(), 'SearchForm',
            new FieldList(
                TextField::create('Search', false)
                    // ->setAttribute('Placeholder', $search_query)
                    ->setAttribute('autocomplete', "off")
                    ->setAttribute('aria-label', "Search")
                    ->setValue($search_query)
            ),
            new FieldList(
                FormAction::create('Results', 'Suchen')
                    // ->setUseButtonTag(true)
            )
        );
        $form->setFormMethod('GET');
        $form->setTemplate('/App/Includes/SearchForm');

        return $form;
    }

    public function Results()
    {
        $hitsPerPage = 25;

        $search_query = $this->getOwner()->request->getVar('Search');
        $paginatedPageNum = floor($this->getOwner()->request->getVar('start') / $hitsPerPage);

        $results = Injector::inst()->get(AlgoliaQuerier::class)->fetchResults(
            'SoliqueRecruiting',
            $search_query, [
                'page' => $this->getOwner()->request->getVar('start') ? $paginatedPageNum : 0,
                'hitsPerPage' => $hitsPerPage
            ]
        );

        if($search_query && $results) {
            return [
                'Results' => $results,
                'Query' => $this->getOwner()->request->getVar('Search')
            ];
        }
        return [];
    }
}
