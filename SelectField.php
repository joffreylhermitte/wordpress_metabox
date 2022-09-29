<?php


class SelectField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public array $options;

    public function __construct($label,$id, $idPost,$data){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->options = $data;

    }

    public function buildSelectField(){
        return Metabox::view('select',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=>$this->nameInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "options"=>$this->options
        ]);
    }
}