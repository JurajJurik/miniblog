<?php 

function form_case($form_case)
{
    global $item;
    global $base_url;

    

    switch ($form_case) {
        case 'add':?>
        <form id="add-form" action="_inc/add-item.php" class="col-sm-6" method="post">
            <p class="form-group">
                <textarea name="message" id="text" rows="1" placeholder="is there anything?" class="form-control" autofocus='true'></textarea>
            </p>
    
            <p class="form-group submit-button">
                <input type="submit" value="add new thing" class="btn-sm btn-danger">
            </p>
        </form>
        <?php
            break;
    
        case 'edit':?>
            <form id="edit-form" action="_inc/edit-item.php" class="col-sm-6" method="post">
                <p class="form-group">
                    <textarea name="message" id="text" rows="3" class="form-control"><?php echo($item) ?></textarea>
                </p>
    
                <p class="form-group">
                    <input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" class="btn-sm btn-danger">
                    <input type="submit" value="edit item" class="btn-sm btn-danger">
                    <span class="controls">
                        <a href="<?php echo $base_url ?>" class="delete-link text-muted">back</a>
                    </span>
                </p>
            </form>
        <?php
            break;
    
        case 'delete':?>
            <form id="delete-form" action="_inc/delete-item.php" class="col-sm-6" method="post">
                <p class="form-group">
                    <textarea disabled name="message" id="text" rows="3" class="form-control"><?php echo($item) ?></textarea>
                </p>
    
                <p class="form-group">
                    <input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" class="btn-sm btn-danger">
                    <input type="submit" value="delete item" class="btn-sm btn-danger">
                    <span class="controls">
                        <a href="<?php echo $base_url ?>" class="delete-link text-muted">back</a>
                    </span>
                </p>    
            </form>
        <?php
            break;
    }
}



?>