<?php


class Metabox
{


    public static function view($view, $variables = [])
    {
        extract($variables);

        ob_start();

        include  get_template_directory().'/inc/package_meta/views/'.$view.'.php';


        return ob_get_clean();
    }
}