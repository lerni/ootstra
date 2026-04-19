# PHPActor Configuration for Silverstripe

This directory contains PHPActor-specific configuration and stub files to improve static analysis and IDE support for Silverstripe CMS projects.

## Stub Files

### `silverstripe_globals.php`
Provides type information for Silverstripe's global helper functions:
- `_t()` - Internationalization/translation function
- `singleton()` - Singleton pattern implementation
- `project()` - Get project name

These functions are defined in `vendor/silverstripe/framework/src/includes/functions.php` but need explicit stubs for PHPActor to recognize them.

## ORM Magic Methods

Silverstripe's ORM generates magic methods dynamically based on static relation properties. PHPActor cannot automatically infer these, so you must add PHPDoc annotations to your DataObject classes.

### Relation Type Patterns

Add `@method` annotations to your class docblock based on your relations:

#### `has_one` Relations
```php
use SilverStripe\Assets\Image;

/**
 * @method Image|null Image()
 */
class MyPage extends Page
{
    private static $has_one = [
        'Image' => Image::class
    ];
}
```

#### `has_many` Relations
```php
use SilverStripe\ORM\HasManyList;

/**
 * @method HasManyList|Comment[] Comments()
 */
class BlogPost extends DataObject
{
    private static $has_many = [
        'Comments' => Comment::class
    ];
}
```

#### `many_many` Relations
```php
use SilverStripe\ORM\ManyManyList;

/**
 * @method ManyManyList|Tag[] Tags()
 */
class Article extends DataObject
{
    private static $many_many = [
        'Tags' => Tag::class
    ];
}
```

#### `belongs_to` Relations
```php
/**
 * @method Page|null Parent()
 */
class Block extends DataObject
{
    private static $belongs_to = [
        'Parent' => Page::class
    ];
}
```

### Return Type Syntax

The pipe syntax `|` allows both:
- The list class (e.g., `ManyManyList`) - for accessing list methods like `count()`, `filter()`
- The array type (e.g., `Tag[]`) - for IDE autocomplete when iterating

For `has_one` relations, use `|null` since the relation might not exist.

### Best Practices

1. **Always add `@method` annotations** for all ORM relations in your DataObject classes
2. **Import the list classes** at the top of your file:
   - `use SilverStripe\ORM\HasManyList;`
   - `use SilverStripe\ORM\ManyManyList;`
3. **Use `self::class`** instead of `__CLASS__` in `_t()` calls for better refactoring support
4. **Keep annotations in sync** with your `$has_one`, `$has_many`, `$many_many` definitions

## Further Reading

- [PHPActor Documentation](https://phpactor.readthedocs.io/)
- [Silverstripe ORM Documentation](https://docs.silverstripe.org/en/6/developer_guides/model/data_model_and_orm/)
- [Silverstripe Relations](https://docs.silverstripe.org/en/6/developer_guides/model/relations/)
