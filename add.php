<?php




$page_title = 'Add new';

include_once "_partials/header.php"; 

if (isset( $_SESSION['form_data'] ) ) {
	extract( $_SESSION['form_data'] );
	unset( $_SESSION['form_data'] );
}


?>

<section class="box">
		<form action="<?= BASE_URL ?>/_admin/add-item.php" method="post" class="post">
			<header class="post-header">
				<h1 class="box-heading">
					Add new post
				</h1>
			</header> 

			<div class="form-group">
				<input type="text" name="title" class="form-control" value="<?= $title ?: '' ?>" placeholder="title your shit">
			</div>

			<div class="form-group">
				<textarea name="text" class="form-control" rows="16" placeholder="write your shit"><?= $text ?: '' ?></textarea>
			</div>

            <div class="form-group">
				<?php foreach ( get_all_tags() as $tag) : ?>
                    <label class="mar-right">
                        <input type="checkbox" name="tags[]" value="<?= $tag->id?>"
                        <?= $tag->checked ||in_array( $tag->id, $tags ?: [] ) ? 'checked' : '' ?>>
                        <?= plain( $tag->tag )?>
                    </label>
                <?php endforeach ?>
                
                
			</div>

			<div class="form-group">			
				<button type="submit" class="btn btn-primary">Add post</button>
				<span class="or">
					or <a href="<?= BASE_URL ?>">cancel</a>
				</span>
			</div>
		</form>
	</section>

    



<?php include_once "_partials/footer.php" ?>
