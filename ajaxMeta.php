<?php
add_action('wp_ajax_ajaxmeta','addMeta');
add_action('wp_ajax_nopriv_ajaxmeta','addMeta');

function addMeta(){
    $nomFonction = $_POST['nomFonction'];
    $postType = $_POST['typePost'];
    $nonce = $_POST['nonceField'];
    $fichier = $_POST['fichier'];

    $file = fopen(get_template_directory()."/inc/custom-meta-".$fichier.".php",'w+');

    $newLine = "<?php"."\n\n";

    fwrite($file,$newLine);
    $fields = json_decode( html_entity_decode( stripslashes ($_POST['fields'] ) ) );

    $includeLine = "include_once 'package_meta/Field.php';\n";
    fwrite($file,$includeLine);

    $types = [];
    foreach($fields as $field){
        array_push($types,$field->type);
    }
    $uniqueTypes = array_unique($types);
    foreach($uniqueTypes as $uniqueType){
        if($uniqueType !== "Field"){
            $includeType = 'include_once "package_meta/'.$uniqueType.'.php";'."\n";
            fwrite($file,$includeType);
        }
    }

    $part1 = "\n".'function add_custom_box_'.$nomFonction.'(){'."\n".'
                add_meta_box('."\n".
        "\t\t\t\t'".$nomFonction."_metabox',\n".
        "\t\t\t\t'Informations',\n".
        "\t\t\t\t'".$nomFonction."_metabox_callback',\n".
        "\t\t\t\t'".$postType."',\n".
        "\t\t\t\t'normal',\n".
        "\t\t\t\t'default'\n".
        "\t\t\t\t);\n".
        "}\n".
        "add_action('add_meta_boxes','add_custom_box_".$nomFonction."');\n\n".
        'function '.$nomFonction.'_metabox_callback($post){'."\n";

    fwrite($file,$part1);



    foreach($fields as $field){
        if($field->type === "Field"){
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->texte"."','"."$field->label"."','"."$field->nom"."',".'$post->ID);'."\n";
            fwrite($file,$line);
        } elseif ($field->type === "ImageField" || $field->type === "FileField") {
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.",'"."$field->bouton"."'".');'."\n";
            fwrite($file,$line);
        } elseif($field->type === "SelectField") {
            $options = explode(',',$field->options);
            $arrayOptions = [];
            foreach ($options as $option){
                $arrayOptions[$option] = $option;
            }
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.",".var_export($arrayOptions,true).');'."\n";
            fwrite($file,$line);

        } elseif($field->type === "PostSelectField" || $field->type === "PostCheckboxField"){
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.",'"."$field->post"."'".');'."\n";
            fwrite($file,$line);
        } elseif ($field->type === "FileLinkField" || $field->type === "SelectPageField" ){
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.');'."\n";
            fwrite($file,$line);
        } elseif($field->type === "BundleImageField") {
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.","."$field->nombre".",'"."$field->bouton"."'".');'."\n";
            fwrite($file,$line);
        } elseif($field->type === "BundleField"){
            $line = "\t".'$'."$field->nom".' = new '."$field->type"."('"."$field->label"."','"."$field->nom"."',".'$post->ID'.","."$field->nombre".');'."\n";
            fwrite($file,$line);
        }

    }

    $part2 = "\t"."wp_nonce_field('somerandomstr','_".$nonce."');\n".
        "\t?>\n".
        "\t<table class='form-table'>"."\n".
        "\t\t<tbody>"."\n".
        "\t\t<?php"."\n";



    fwrite($file,$part2);

    foreach ($fields as $field){

        if($field->type === "FileField"){
            $lineecho = "\t\t".'echo $'."$field->nom".'->buildFileField();'."\n";

        } elseif($field->type === "FileLinkField"){
            $lineecho = "\t\t".'echo $'."$field->nom".'->buildFileLinkField();'."\n";
        } elseif($field->type === "SelectField"){
            $lineecho = "\t\t".'echo $'."$field->nom".'->buildSelectField();'."\n";
        } else {
            $lineecho = "\t\t".'echo $'."$field->nom".'->buildField();'."\n";
        }
        fwrite($file,$lineecho);

    }

    $part3 = "\t\t?>\n".
        "\t\t</tbody>"."\n".
        "\t</table>"."\n".
        "\t<?php"."\n".
        "}\n\n";


    fwrite($file,$part3);

    $part4 = 'function save_meta_'.$nomFonction.'($post_id){'."\n\n\t".
        'if( ! isset( $_POST["_'.$nonce.'"] ) || ! wp_verify_nonce( $_POST["_'.$nonce.'"],'."'somerandomstr'".')){'."\n".
        "\t".'return $post_id;'."\n\t".
        '}'."\n\n";

    fwrite($file,$part4);

    foreach ($fields as $field){

        if($field->type === "Field" && $field->texte === "wysiwyg"){
            $linesave = "\t".'Field::saveEditorField('."'"."$field->nom"."',".'$post_id);'."\n";

        } elseif($field->type === "FileField"){
            $linesave = "\t".'Field::saveUrlField('."'"."$field->nom"."',".'$post_id);'."\n";
        } elseif($field->type === "BundleField" || $field->type === "BundleImageField"){
            $linesave = "\t".'Field::saveBundleField('."'"."$field->nom"."',".'$post_id);'."\n";
        } else {
            $linesave = "\t".'Field::saveTextField('."'"."$field->nom"."',".'$post_id);'."\n";
        }
        fwrite($file,$linesave);

    }

    $part5 = "\t".'return $post_id;'."\n".
        "}\n\n".
        "add_action('save_post','save_meta_".$nomFonction."',10,2);";

    fwrite($file,$part5);



    fclose($file);

    $file2 = fopen(get_template_directory()."/inc/customCms.php",'a+');

    if($postType === 'page'){
        $pageId = $_POST['pageId'];
        $includeFile = 'if (isset($_GET["post"]) && $_GET["post"] === "'.$pageId.'") {'."\n".
            "\t"."require get_template_directory() . '/inc/custom-meta-".$fichier.".php';".
            "\n}";


    } else {
        $includeFile = "include get_template_directory() . '/inc/custom-meta-".$fichier.".php';\n";
    }
    fwrite($file2,$includeFile);

    fclose($file2);



    showJson('ok');

}