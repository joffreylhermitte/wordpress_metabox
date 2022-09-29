<?php

class FileLinkField
{
    public string $idInput;


    public string $postId;

    public string $labelInput;




    public function __construct($label,$id, $idPost){
        $this->labelInput = $label;
        $this->idInput = $id;

        $this->postId = $idPost;



    }

    public function buildFileLinkField(){
        return Metabox::view('fileLink',["id"=>$this->idInput,
            "label"=>$this->labelInput,
            "value"=>get_post_meta($this->postId,$this->idInput,true),

        ]);
    }
}