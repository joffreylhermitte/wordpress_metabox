<?php

include_once 'Metabox.php';

class BundleImageField
{
    public string $idInput;

    public string $nameInput;

    public string $postId;

    public string $labelInput;

    public string $numberInput;

    public string $idButton;


    public function __construct($label,$id, $idPost,$number,$button){
        $this->labelInput = $label;
        $this->idInput = $id;
        $this->nameInput = $id;
        $this->postId = $idPost;
        $this->numberInput = $number;
        $this->idButton = $button;




    }


    public function buildField(){

        return Metabox::view('bundleImage',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "name"=> $this->nameInput,
            "number"=> $this->numberInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),
            "button"=>$this->idButton
        ]);
    }
}