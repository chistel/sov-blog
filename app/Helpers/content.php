<?php

/**
 * @param string $content
 * @param int $length
 * @param string $more
 * @return string
 */
function getExcerpt(string $content, int $length = 40, string $more = '...' ): string
{
    $excerpt = strip_tags( trim( $content ) );
    $words = str_word_count( $excerpt, 2 );
    if ( count( $words ) > $length ) {
        $words = array_slice( $words, 0, $length, true );
        end( $words );
        $position = key( $words ) + strlen( current( $words ) );
        $excerpt = substr( $excerpt, 0, $position ) . $more;
    }
    return $excerpt;
}
