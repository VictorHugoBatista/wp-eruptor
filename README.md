# wp-eruptor
Extend your single pages like lava in the water with less setup

## Simple usage
Add the lib by composer with the command below:
```shell
composer require victorhugobatista/wp-eruptor 
```
Add the code below to your functions.
```php
use victorhugobatista\WpEruptor\Eruptor;
Eruptor::initialize();
```

The file structure to place the templates must be like below:
 * Template root directory (**by now, the template folder must be placed here**)
   * single-page-children (**by now, this name can't be changed**)
     * single-book (**this represents the name of template file of single pages, in case single-book.php**)
       * child-a.php (**/book/existing-post-name/child-a**)
       * child-b.php (**/book/existing-post-name/child-b**)
       * child-c.php (**/book/existing-post-name/child-c**)
     * single-movie
       * child-d.php (**/movie/existing-post-name/child-d**)
       * child-e.php (**/movie/existing-post-name/child-e**)
       * child-f.php (**/movie/existing-post-name/child-f**)

The post id of parent single page will be available in the templates as:
```php
<?php echo $pageData['post-id'] ?>
```

## Hooks reference
Hook | Description
---- | -----------
**eruptor/data** | Inject data to all templates
**eruptor/data/type/{post-type-slug}** | Inject data to templates children of posts of an post type by slug
**eruptor/data/post/{parent-single-post-id}** | Inject data to templates children of an specific post by id
**eruptor/data/template/{template-slug}** | Inject data to one template by name

### Example for eruptor/data* hook:
**/!\ The wildcard * can be replace with any eruptor/data filters above /!\\**
```php
add_filter('eruptor/data*', function($data) {
  return array_merge($data, [
    'new-data' => 'new data added to template',
  ]);
});
```
The new data will be available on template on **$pageData** array:
```php
<?php echo $pageData['new-data'] ?>
```

## Next steps (from @todo comments added to the code)
 * To receive the root directory to read the templates on main class.
 * To receive what post types have to be added to routes on main class.
 * Add filters to allow the modification of header, content and footer by post type, post name and template name.
