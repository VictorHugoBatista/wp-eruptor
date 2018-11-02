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

## Next steps (from @todo comments added to the code)
 * To receive the root directory to read the templates on main class.
 * To receive what post types have to be added to routes on main class.
 * Add filters to allow the modification of header, content and footer by post type, post name and template name.
 * Add filters to inject data to the templates, by post type, post name and template name.
