<?php

use Kraftausdruck\Models\JobPosting;
use Wilr\GoogleSitemaps\GoogleSitemap;

GoogleSitemap::register_dataobjects([JobPosting::class], 'weekly','1');
