<?php
namespace victorhugobatista\WpEruptor\BO;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Route\QueryRoute;

class PostTypeRoute
{
    private $postType;
    private $cortexRoutes;

    public function __construct($postType, RouteCollectionInterface $routes)
    {
        $this->postType = $postType;
        $this->cortexRoutes = $routes;
        $this->addRoute();
    }

    private function addRoute()
    {
        if (! $this->postType->rewrite)  {
            return;
        }
        $this->cortexRoutes->addRoute(new QueryRoute(
            "{$this->postType->rewrite['slug']}/{post-name}/{single-child-name}",
            function (array $matches) {
                echo 'child page';
                die();
            }
        ));
    }
} 
