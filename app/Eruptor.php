<?php
namespace victorhugobatista\WpEruptor;

use Brain\Cortex;
use Brain\Cortex\Route\RouteCollectionInterface;
use victorhugobatista\WpEruptor\BO\PostTypeRoute;

/**
 * Main class, responsible for initialize the cortex routes for the post types.
 */
class Eruptor
{
    /**
     * Flag who control if the library is initialized.
     *
     * @var boolean
     */
    private static $initialized = false;

    /**
     * Initialize the cortex routes. Boot the cortex feature by
     * default, but is possible deactivate this behaviour.
     * Can be called one time per request.
     *
     * @todo To receive the root directory to read the templates.
     * @todo To receive what post types have to be added to routes.
     *
     * @param boolean $bootCortex Initialize the cortex feature if true (default).
     */
    public static function initialize($templateRootDirectory = '', $bootCortex = true)
    {
        if (! static::$initialized) {
            if ($bootCortex) {
                Cortex::boot();
            }
            add_action('cortex.routes', function(RouteCollectionInterface $routes) use ($templateRootDirectory) {
                $allPostTypes = get_post_types([], 'objects');
                foreach ($allPostTypes as $postType) {
                    new PostTypeRoute($postType, $routes, $templateRootDirectory);
                }
            });
            static::$initialized = true;
        }
    }
}
