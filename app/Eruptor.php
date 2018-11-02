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
     * Initialize the cortex routes. Boot the cortex feature by
     * default, but is possible deactivate this behaviour.
     * 
     * @todo Receive the root directory to read the templates.
     * @todo Receive what post types have to be added to routes.
     *
     * @param boolean $bootCortex Initialize the cortex feature if true (default).
     */
    public function __construct($bootCortex = true)
    {
        if ($bootCortex) {
            Cortex::boot();
        }
        add_action('cortex.routes', function(RouteCollectionInterface $routes) {
            $allPostTypes = get_post_types([], 'objects');
            foreach ($allPostTypes as $postType) {
                new PostTypeRoute($postType, $routes);
            }
        });
    }
}
