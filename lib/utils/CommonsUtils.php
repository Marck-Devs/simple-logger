<?php
namespace MarckDevs\SimpleLogger\Utils;
class CommonsUtils{
    public static function starts_with( $haystack, $needle ) {
        $length = strlen( $needle );
        return substr( $haystack, 0, $length ) === $needle;
   }

   public static function ends_with( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}
}