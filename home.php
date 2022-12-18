<?php 

    try {
        $results = get_posts();
    } catch (PDOException $e) {
        $results = [];
    }

   


include_once "_partials/header.php" ?>

    <div class="page-header">
        <h1>VERY MUCH HOMEPAGE</h1>

    </div>

    <section class="box post-list">
        <h1 class="box-heading text-muted"> This is a BLOG!</h1>
        <?php if(count ($results)): foreach ($results as $post): ?>

            <article id="post-<?= $post->id ?>"  class="post">
                <header class="post-header">
                    <h2>
                        <a href="<?= $post->link?>"><?= $post->title ?></a>
                        <time datetime="<?= $post->date?>">
                            <small>/&nbsp;<?= $post->time ?></small>
                        </time>
                    </h2>
                    <?php include '_partials/tags.php'; ?>
                </header>
                <div class="post-content">
                    <p>
                        <?= word_limiter($post->text, 10)?>
                    </p>
                </div>
                <div class="footer post-footer">
                    <a href="<?=$post->link?>" class="read-more">read more</a>
                </div>
            </article>

        <?php endforeach; else : ?>

            <p>Nothing to show.</p>
        
        <?php endif; ?>
        
        
        
    </section>

    

<?php include_once "_partials/footer.php" ?>