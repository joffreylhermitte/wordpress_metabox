<?php

include_once 'Metabox.php';

class BundleField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public string $numberInput;

    public string $typeInput;


    public function __construct($type,$label,$id, $idPost,$number){
        $this->typeInput = $type;
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->numberInput = $number;




    }


    public function buildField(){

        return Metabox::view($this->typeInput,["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=> $this->nameInput,
            "number"=> $this->numberInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true)
        ]);
    }
}