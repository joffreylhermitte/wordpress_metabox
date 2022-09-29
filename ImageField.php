<?php


class ImageField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public string $idButton;

    public function __construct($label,$id, $idPost,$button){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->idButton = $button;


    }

    public function buildField(){
        return Metabox::view('image',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "button"=>$this->idButton
        ]);
    }
}