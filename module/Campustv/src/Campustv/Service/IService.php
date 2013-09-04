<?php

namespace Campustv\Service;

use Campustv\Model\IEntity;

interface IService {

    public function fetchAll();

    public function get($id);

    public function save(IEntity $model);

    public function delete($id);
}

?>
