<?php

namespace nathancox\EmbedField\Model;

use DOMDocument;
use SilverStripe\ORM\DataObject;
use Embed\Embed;

/**
 * Represents an oembed object.  Basically populated from oembed so the front end has quick access to properties.
 */
class EmbedObject extends DataObject {

	private static $db = array(
		'SourceURL' => 'Varchar(255)',
		'Title' => 'Varchar(255)',
		'Type' => 'Varchar(255)',
		'Version' => 'Float',

		'Width' => 'Int',
		'Height' => 'Int',

		'ThumbnailURL' => 'Varchar(355)',
		'ThumbnailWidth' => 'Int',
		'ThumbnailHeight' => 'Int',

		'ProviderURL' => 'Varchar(255)',
		'ProviderName' => 'Varchar(255)',

		'AuthorURL' => 'Varchar(255)',
		'AuthorName' => 'Varchar(255)',

		'EmbedHTML' => 'HTMLText',
		'URL' => 'Varchar(355)',
		'Origin' => 'Varchar(355)',
		'WebPage' => 'Varchar(355)'
	);

	private static $table_name='EmbedObject';

	public $updateOnSave = false;

	public $sourceExists = false;

	function sourceExists() {
		return ($this->ID != 0 || $this->sourceExists);
	}

	function updateFromURL($sourceURL = null) {
		if ($this->SourceURL) {
			$sourceURL = $this->SourceURL;
		}
		$info = Embed::create($sourceURL);
		//Oembed::get_oembed_from_url($sourceURL);

		$this->updateFromObject($info);
	}

	function updateFromObject($info) {
		if ($info && $info->getWidth()) {
			$this->sourceExists = true;

			$this->Title = $info->getTitle();
			$this->Type = $info->type;

			$this->Width = $info->getWidth();
			$this->Height = $info->getHeight();

			$this->ThumbnailURL = $info->getImage();
			$this->ThumbnailWidth = $info->thumbnail_width;
			$this->ThumbnailHeight = $info->thumbnail_height;

			$this->ProviderURL = $info->provider_url;
			$this->ProviderName = $info->provider_name;


			$this->AuthorURL = $info->author_url;
			$this->AuthorName = $info->author_name;

			$embed = $info->getCode();

            $dom = new DOMDocument();
            $dom->loadHTML($embed);
            $iframe = $dom->getElementsByTagName("iframe");
            $iframe->item(0)->setAttribute('loading','lazy');
            $embed = $dom->saveXML($iframe->item(0));

			$this->EmbedHTML = $embed;
			$this->URL = $info->url;
			$this->Origin = $info->origin;
			$this->WebPage = $info->web_page;

		} else {
			$this->sourceExists = false;
		}
	}

	/**
	 * Return the object's properties as an array
	 * @return array
	 */
	function toArray() {
		if ($this->ID == 0) {
			return array();
		} else {

			$array = $this->toMap();
			unset($array['Created']);
			unset($array['Modified']);
			unset($array['ClassName']);
			unset($array['RecordClassName']);
			unset($array['ID']);
			unset($array['SourceURL']);

			return $array;
		}



	}

	function onBeforeWrite() {
		parent::onBeforeWrite();

		if ($this->updateOnSave === true) {
			$this->updateFromURL($this->SourceURL);
			$this->updateOnSave = false;
		}

	}


	function forTemplate() {
		if ($this->Type) {
			return $this->renderWith($this->ClassName.'_'.$this->Type);
		}
		return false;
	}

	/**
	 * This is used for making videos responsive.  It uses the video's actual dimensions to calculate the height needed for it's aspect ratio (when using this technique: http://alistapart.com/article/creating-intrinsic-ratios-for-video)
	 * @return string 	Percentage for use in CSS
	 */
	function getAspectRatioHeight() {
		return ($this->Height / $this->Width) * 100 . '%';
	}

}
