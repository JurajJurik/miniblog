<?php

    //include
    require '../_inc/config.php';

    // just to be safe
    if ( ! logged_in()) {
        redirect('/');
    }

    if (! $data = validate_post() ) {
        redirect('back');
    }

    extract($data);
    $slug = slugify($title);

    // add new title and text

    $query = $db->prepare("
        INSERT INTO posts
            (title, text, slug)
        VALUES
            (:title, :text, :slug)
    ");

    $insert = $query -> execute([
        'title'     => $title,
        'text'      => $text,
        'slug'      => $slug
    ]);


    if (! $insert) 
    {
        flash()->warning( 'sorry, girl' );
        redirect('back');
    }

    // great success
    $post_id = $db->lastInsertId();

    // if we have tags, add them

    if ( isset( $tags ) && $tags = array_filter( $tags)) 
    {
        foreach ($tags as $tag_id) 
        {
            $insert_tags = $db->prepare("
                INSERT INTO posts_tags
                VALUES (:post_id, :tag_id)
            ");

            $insert_tags->execute([
                'post_id' => $post_id,
                'tag_id'  => $tag_id
            ]);
        }
    }

    // redirect

    flash()->success('yay, new one!');
        redirect( get_post_link([
            'id'    => $post_id,
            'slug'  => $slug,
        ]));