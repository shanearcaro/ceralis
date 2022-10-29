<?php
    $post = $_POST;
    print_r(array_keys($post));
    $post = json_encode($_POST);
    echo $post;

    
?>