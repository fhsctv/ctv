<?php

namespace Futhuer;

/**
 * Description of Random
 *
 * @author juri
 */
class Random {



    /**
     * Returns a random number which is different from that one in $last
     * @param int $from
     * @param int $to
     * @param int $last
     * @return int
     */
    public static function repeatlessRandom($from, $to, $last){

        $result = mt_rand($from, $to);

        //var_dump($result);

        return ($result != $last) ? $result : self::repeatlessRandom($from, $to, $last);
    }

}

?>
