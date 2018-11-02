<?php
namespace victorhugobatista\WpEruptor\BO;

use Brain\Cortex\Route\RouteCollectionInterface;
use Brain\Cortex\Route\QueryRoute;
use victorhugobatista\WpEruptor\Database\QueryPost;
use victorhugobatista\WpEruptor\View\Templater;

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
        $postTypeSlug = $this->postType->rewrite['slug'];
        $this->cortexRoutes->addRoute(new QueryRoute(
            "{$postTypeSlug}/{postName}/{singleChildName}",
            function (array $matches) use ($postTypeSlug) {
                $queryPost = new QueryPost(
                    $this->postType->name,
                    $matches['postName']
                );
                if (! $queryPost->postExists()) {
                    new Templater();
                }
                new Templater(
                    $postTypeSlug,
                    $matches['singleChildName']
                );
                die();
            }
        ));
    }
} 
