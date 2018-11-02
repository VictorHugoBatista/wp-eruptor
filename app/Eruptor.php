<?php
namespace victorhugobatista\WpEruptor;

use Brain\Cortex;
use Brain\Cortex\Route\RouteCollectionInterface;
use victorhugobatista\WpEruptor\BO\PostTypeRoute;

class Eruptor
{
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
