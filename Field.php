<?php

include_once 'Metabox.php';

class Field
{
    public string $typeInput;

    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;




    public function __construct($type,$label,$id, $idPost){
        $this->typeInput = $type;
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;


    }

    public function buildField(){
        return Metabox::view($this->typeInput,["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true)
        ]);
    }

    public static function saveTextField($meta,$post){
        if( isset( $_POST[ $meta ] ) ) {
            update_post_meta( $post, $meta, sanitize_text_field( $_POST[ $meta ] ) );
        }
    }

    public static function saveEditorField($meta,$post){
        if( isset( $_POST[ $meta ] ) ) {
            update_post_meta( $post, $meta, wp_kses_post( $_POST[ $meta ] ) );
        }
    }

    public static function saveUrlField($meta,$post){
        if( isset( $_POST[ $meta ] ) ) {
            update_post_meta( $post, $meta, esc_url_raw( $_POST[ $meta ] ) );
        }
    }

    public static function saveCheckboxField($meta,$post){
        if( isset( $_POST[ $meta ] ) ) {
            update_post_meta( $post, $meta, sanitize_text_field( $_POST[ $meta ] ) );
        } else{
            delete_post_meta($post, $meta);
        }
    }

    public static function saveBundleField($meta,$post){
        $data = [];
        $index = 1;

        if( isset( $_POST[ $meta.'_'.$index ] ) ) {
            while (isset($_POST[ $meta.'_'.$index ])){
                if ($_POST[ $meta.'_'.$index ] !== ""){
                    array_push($data,$_POST[ $meta.'_'.$index ]);
                }
                $index++;
            }
            update_post_meta( $post, $meta, $data );
        }

    }

}