<?php

namespace Futhuer;

/**
 * Description of UrlCheck
 *
 * @author juri
 */
class UrlCheck {


    const NOT_FOUND_HTTP_HEADER_STRING = 'HTTP/1.1 404 Not Found';
    const NOT_FOUND = false;
    const FOUND = true;

    /**
     * Checks whether a website exists or not
     * @param string $url
     * @return boolean
     */
    public static function checkUrl($url){
//        var_dump(get_headers($url,1));
//        var_dump(get_headers($url,1)[0]);

        if(get_headers($url,1)[0] == self::NOT_FOUND_HTTP_HEADER_STRING)
                return self::NOT_FOUND;

        return self::FOUND;
    }

}

?>
