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
    
    // add new title and text
    
    $post = get_post( $post_id, false );

    //check title
    $new_title = $data['title'];
    $old_title = $post->title;

    if ($new_title !== $old_title) {
        
        $update_title = $db->prepare("
            UPDATE posts SET
                title = :title
            WHERE 
                id = :post_id
        ");
    
        $update_title -> execute([
            'title'     => $new_title,
            'post_id'   => $post_id
        ]);

        if ($update_title->rowCount() ) 
        {
            $update_title = 'success';
        }
    }

    //check text
    $new_text = $data['text'];
    $old_text = $post->text;

    if ($new_text !== $old_text) {
        
        $update_text = $db->prepare("
            UPDATE posts SET
                text = :text
            WHERE 
                id = :post_id
        ");
    
        $update_text -> execute([
            'text'     => $new_text,
            'post_id'   => $post_id
        ]);

        if ($update_text->rowCount() ) 
        {
            $update_text = 'success';
        }
    }

    // remove all tags for this post

    $delete_tags = $db->prepare("
        DELETE FROM posts_tags
        WHERE post_id = :post_id
    ");

    $delete_tags->execute([
        'post_id' => $post_id
    ]);

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

    //redirect

    if (!isset($update_title) && !isset($update_text)) {
        flash()->warning( "You didn't even change anything!" );
        redirect( get_post_link($post));
    }
    
    flash()->success('yay, changed it!');
    redirect( get_post_link($post));