<?php
namespace victorhugobatista\WpEruptor\BO;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Route\QueryRoute;
use victorhugobatista\WpEruptor\Database\QueryPost;

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
            "{$this->postType->rewrite['slug']}/{postName}/{singleChildName}",
            function (array $matches) {
                $queryPost = new QueryPost(
                    $this->postType->name,
                    $matches['postName']
                );
                die();
            }
        ));
    }
} 
