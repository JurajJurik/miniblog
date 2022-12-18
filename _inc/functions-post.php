<?php 

function get_post ( $id = 0, $auto_format = true )
{
    //we have no id
    if (!$id && !$id = segment(2)) {
        return false;
    }

    // $id must be integer
    if ( !filter_var($id, FILTER_VALIDATE_INT )) {
        return false;
    }

    global $db;

    $query = $db->prepare( create_posts_query("WHERE p.id = :id"));
    $query -> execute(['id' => $id]);

    if ( $query->rowCount() === 1) {
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($auto_format) {
            $result = format_post( $result, true);
        }else {
            $result = (object) $result;
        }
    }
    else {
        $result = [];
    }

    return $result;
}

function get_posts( $auto_format = true )
{
    global $db;

    $query = $db->query(create_posts_query());

    if ( $query->rowCount()) {
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($auto_format) {
            $results = array_map('format_post', $results);
        }
    }
    else {
        $results = [];
    }

    return $results;
}

function format_post ($post, $format_text = false)
{   
    $post = array_map('trim', $post);

    // clean data
    $post['title'] = plain($post['title']);
    $post['text'] = plain($post['text']);
    $post['tags'] = $post['tags'] ? explode('~||~', $post['tags']) : [];
    $post['tags'] = array_map('plain', $post['tags']);

    //tag me up
    if ($post['tags']) foreach ($post['tags'] as $tag) {
        $post['tag_links'][$tag] = BASE_URL . '/tag/' . urlencode( $tag );
        $post['tag_links'][$tag] = filter_var($post['tag_links'][$tag],FILTER_SANITIZE_URL);
    } 

    //create link to post [/post/:id/:slug]
    $post['link'] = get_post_link( $post );
    $post['link'] = filter_var($post['link'], FILTER_SANITIZE_URL);

    //dates
    $post['timestamp'] = strtotime($post['created_at']);
    $post['time'] = str_replace(' ', '&nbsp;', date('j M Y, G:i' , $post['timestamp']));
    $post['date'] = date('Y-m-d', $post['timestamp']);

    //teaser
    $post['teaser'] = word_limiter($post['text'], 10);

    //format text
    if ($format_text) {
        $post['text'] = filter_url($post['text']);
        $post['text'] = add_paragraphs($post['text']);
    }

    $post['email'] = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
    $post['user_link'] = BASE_URL . '/user/' . $post['user_id'];
    $post['user_link'] = filter_var($post['user_link'], FILTER_SANITIZE_URL);


    return (object) $post;
}

function get_posts_by_tag ( $tag = '', $auto_format = true )
{
    //we have no id
    if (!$tag && !$tag = segment(2)) {
        return false;
    }

    // $id must be string
    $tag = urldecode( $tag );
    $tag = filter_var($tag, FILTER_SANITIZE_STRING );

    global $db;

    $query = $db->prepare( create_posts_query("WHERE t.tag = :tag"));
    $query -> execute(['tag' => $tag]);

    if ( $query->rowCount()) {
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($auto_format) {
            $results = array_map('format_post', $results);
        }
    }
    else {
        $results = [];
    }

    return $results;
}

function create_posts_query($where = '')
{
    $query = "
        SELECT p.*, u.email, GROUP_CONCAT(t.tag SEPARATOR '~||~') AS tags
        FROM posts p
        LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
        LEFT JOIN tags t ON (t.id = pt.tag_id)
        LEFT JOIN phpauth_users u ON (p.user_id = u.id)
    ";

    if ($where) {
        $query .= $where;
    }
    $query .= " GROUP BY p.id";
    $query .= " ORDER BY p.created_at DESC";

    return trim( $query );
}

function get_edit_link($post)
{
    return get_post_link( $post, 'edit');
}

function get_delete_link($post)
{
    return get_post_link( $post, 'delete');
}



function get_post_link( $post, $type = 'post')
{
    if (is_object ($post)) 
    {
        $id   = $post->id;
        $slug = $post->slug; 
    }
    else
    {
        $id   = $post['id'];
        $slug = $post['slug'];
    }

    $link = BASE_URL . "/$type/$id";

    if ( $type === 'post') {
        $link .= "/$slug";
    }

    $link = filter_var( $link, FILTER_SANITIZE_URL);

    return $link;

}

function get_all_tags( $post_id = 0)
{
    global $db;

    $query = $db->query("
        SELECT * FROM tags
        ORDER BY tag ASC
    ");

    $results = $query -> rowCount() ? $query->fetchAll(PDO::FETCH_OBJ) : [];

    if ( $post_id) 
    {
        $query = $db->prepare("
            SELECT t.id FROM tags t
            JOIN posts_tags pt ON t.id = pt.tag_id
            WHERE pt.post_id = :pid
        ");

        $query->execute([$post_id]);

        
        if ($query->rowCount()) 
        {
            $tags_for_post = $query->fetchAll(PDO::FETCH_COLUMN);

            foreach ( $results as $key => $tag )
				{
					$checked = false;
					if ( in_array( $tag->id, $tags_for_post ) ) {
						$checked = true;
					}

					$results[$key]->checked = $checked;
				}
        }
        
    }
    return $results;   
}

function validate_post()
{
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $tags = filter_input(INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

    if (isset($_POST['post_id'])) 
    {
        $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT); 

        // id is required and has to be int
        if (! $post_id) {
            flash()->error("what are you trying to pull here");
        }
    }
    else 
    {
        $post_id = false;
    }
    
    //title required
    if (! $title = trim($title)) {
        flash()->error('you forgot your title');
    }

    //text required
    if (! $text = trim($text)) {
        flash()->error('you forgot your text');
    }

    //if we have error messages, validation didn't go well, we have to redirect
    if (flash()->hasMessages()) 
    {
        $_SESSION['form_data'] = [
            'title' => $title,
            'text'  => $text,
            'tags'  => $tags ?: [],
        ];
        return false;
    }
    return compact(
        'post_id', 'title', 'text', 'tags'
    );
}

function get_posts_by_user ( $user_id = '', $auto_format = true )
{
    //we have no id
    if (!$user_id ) {
        return false;
    }

    global $db;

    $query = $db->prepare( create_posts_query("WHERE p.user_id = :uid"));
    $query -> execute(['uid' => $user_id]);

    if ( $query->rowCount()) {
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($auto_format) {
            $results = array_map('format_post', $results);
        }
    }
    else {
        $results = [];
    }

    return $results;
}