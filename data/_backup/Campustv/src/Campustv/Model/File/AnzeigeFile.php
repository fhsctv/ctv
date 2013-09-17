<?php

namespace Campustv\Model\File;

class AnzeigeFile {

    private $_path = 'public/data/anzeigeFiles/';

    public function save($enterprise, $filename, $data){

        if(!is_dir($this->_path . $enterprise)){
            mkdir($this->_path . $enterprise);
        }


        return file_put_contents($this->_path . $enterprise . '/' . $filename, $data);
    }

    public function read($enterprise, $fileName){
        return file_get_contents($this->_path . $enterprise . '/' . $fileName);
    }

}

?>
