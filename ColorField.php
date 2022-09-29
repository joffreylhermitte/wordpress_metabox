<?php

class ColorField
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
        return Metabox::view('color',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true)
        ]);
    }
}