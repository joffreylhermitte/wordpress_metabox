<?php


class PostSelectField
{

    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public string $postName;

    public function __construct($label,$id, $idPost,$post){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->postName = $post;

    }

    public function buildField(){
        $args = array('post_type' => $this->postName,
            'posts_per_page' => -1,
            'cache_results'  => false,
            'no_found_rows'  => true,);
        $data = get_posts($args);
        return Metabox::view("selectPost",["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "data"=>$data
        ]);
    }
}