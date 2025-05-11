<?php

namespace App\Models;

use App\Models\Testimonial;
use SilverStripe\ORM\DataObject;
use App\Elements\ElementTestimonial;


class TestimonialCategory extends DataObject
{

    private static $table_name = 'TestimonialCategory';

    private static bool $allow_urlsegment_multibyte = true;

    private static $db = [
        'Title'      => 'Varchar'
    ];

    private static $belongs_many_many = [
        // 'Testimonials' => Testimonial::class . '.Categories', // 2222
        // 'Elements' => ElementTestimonial::class . '.Categories' // 1111
        'Testimonials' => Testimonial::class,
        'Elements' => ElementTestimonial::class
    ];
}
