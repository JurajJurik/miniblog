<?php


try {
    $post = get_post( segment(2), false);
} catch (PDOException $e) {
    $post = false;
}

if ( !$post) {
    flash()->error("Doesn't exist!");
    redirect('/');
}


$page_title = 'Edit / ' . $post -> title;

include_once "_partials/header.php" ?>

<section class="box">
		<form action="<?= BASE_URL ?>/_admin/edit-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Edit &ldquo;<?= plain($post->title) ?>&rdquo;
				</h1>
			</header>

			<div class="form-group">
				<input type="text" name="title" class="form-control" value="<?= $post->title ?>" placeholder="title your shit">
			</div>

			<div class="form-group">
				<textarea name="text" class="form-control" rows="16" placeholder="write your shit"><?= $post->text ?></textarea>
			</div>

            <div class="form-group">
				<?php foreach ( get_all_tags( $post->id) as $tag) : ?>
                    <label class="mar-right">
                        <input type="checkbox" name="tags[]" value="<?= $tag->id?>"
                        <?= isset($tag->checked) && $tag->checked ? 'checked' : '' ?>>
                        <?= plain( $tag->tag )?>
                    </label>
                <?php endforeach ?>
                
                
			</div>

			<div class="form-group">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">			
				<button type="submit" class="btn btn-primary">Edit post</button>
				<span class="or">
					or <a href="<?= get_post_link( $post ) ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>

    



<?php include_once "_partials/footer.php" ?>
