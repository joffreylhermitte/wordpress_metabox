<?php


class CheckboxField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public string $valueCheckbox;



    public function __construct($label,$id, $idPost, $value){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->valueCheckbox = $value;



    }

    public function buildField(){
        return Metabox::view('checkbox',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "valueCheckbox"=>$this->valueCheckbox
        ]);
    }
}