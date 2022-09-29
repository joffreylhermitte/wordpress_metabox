<?php

class SelectPageField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;


    public function __construct($label,$id, $idPost){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;


    }

    public function buildField(){
        $args = array('post_type' => 'page',
            'posts_per_page' => -1,
            'cache_results'  => false,
            'no_found_rows'  => true,);
        $data = get_posts($args);
        return Metabox::view("selectPage",["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "data"=>$data
        ]);
    }
}