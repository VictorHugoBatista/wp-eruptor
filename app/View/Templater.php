<?php
namespace victorhugobatista\WpEruptor\View;

class Templater
{
    public function __construct($template = '404')
    {
        ob_start();
        get_header();
        $this->getTemplateContent($template);
        get_footer();
        echo ob_get_clean();
    }

    private function getTemplateContent($template)
    {
        if ('404' === $template) {
            $this->get404Template();
        }
    }

    private function get404Template()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
    }
}
