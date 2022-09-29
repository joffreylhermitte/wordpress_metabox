<?php
add_action('wp_ajax_ajaxpost','addPost');
add_action('wp_ajax_nopriv_ajaxpost','addPost');

function addPost(){
    $nom = $_POST['newPostName'];
    $singulier = $_POST['newSinglePostName'];
    $phraseAll = $_POST['newPostAllName'];
    $slug = $_POST['newPostSlug'];
    $logo = $_POST['newPostLogo'];

    $file = fopen(get_template_directory()."/inc/custom-".$slug.".php",'w+');

    $newLine = "<?php"."\n\n";

    fwrite($file,$newLine);

    $content = '$labels = array('."\n".
        "\t"."'name'                => _x('".$nom."','Post Type General Name'),\n".
        "\t"."'singular_name'       => _x('".$singulier."','Post Type Singular Name'),\n".
        "\t"."'menu_name'           => __('".$nom."'),\n".
        "\t"."'all_items'           => __('".$phraseAll."'),\n".
        "\t"."'view_item'           => __('Voir les ".strtolower($nom)."'),\n".
        "\t"."'add_new_item'        => __('Ajouter'),\n".
        "\t"."'add_new'             => __('Ajouter'),\n".
        "\t"."'edit_item'           => __('Editer'),\n".
        "\t"."'update_item'         => __('Modifier'),\n".
        "\t"."'search_items'        => __('Rechercher'),\n".
        "\t"."'not_found'           => __('Non trouvé'),\n".
        "\t"."'not_found_in_trash'  => __('Non trouvé dans la corbeille'),\n".
        ");\n\n";

    fwrite($file,$content);

    $content2 = '$args = array('."\n".
        "\t"."'label'               => __('".$nom."'),\n".
        "\t"."'description'         => __('".$nom."'),\n".
        "\t"."'labels'              => ".'$labels'.",\n".
        "\t"."'supports'            => array('title','author','editor','thumbnail'),\n".
        "\t"."'map_meta_cap'        => true,\n".
        "\t"."'show_in_rest'        => true,\n".
        "\t"."'hierarchical'        => false,\n".
        "\t"."'public'              => true,\n".
        "\t"."'has_archive'         => false,\n".
        "\t"."'rewrite'             => array('slug'=>'".$slug."'),\n".
        "\t"."'menu_icon'           => '".$logo."',\n".
        ");\n\n".
        "register_post_type('".$slug."',".'$args'.");";

    fwrite($file,$content2);

    fclose($file);

    $file2 = fopen(get_template_directory()."/inc/customCms.php",'a+');
    $includeFile = "\ninclude get_template_directory() . '/inc/custom-".$slug.".php';\n";

    fwrite($file2,$includeFile);

    fclose($file2);

    showJson('ok');
}