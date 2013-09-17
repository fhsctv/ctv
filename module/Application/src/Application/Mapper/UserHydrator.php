<?php

namespace Application\Mapper;

use ZfcUser\Mapper\UserHydrator as ZfcUserHydrator;

class UserHydrator extends ZfcUserHydrator {

    public function extract($object)
    {
        //Preserve parent logic
        $data = parent::extract($object);
        //Avoid errors due to db insertion of null value

        if (empty($data['user_id']))
        {
            unset($data['user_id']);
        }
        return $data;
    }

}

?>
