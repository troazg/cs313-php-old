<?php

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script type='text/javascript'>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>