<?php

namespace Administration\Service;

use Administration\Model\IEntity;

interface IService {

    public function fetchAll();

    public function get($id);

    public function save($data);

    public function delete($id);
}

?>
