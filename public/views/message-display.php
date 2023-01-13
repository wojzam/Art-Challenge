<div class="info">
    <?php
    if (isset($info)) {
        foreach ($info as $i) {
            echo $i;
        }
    }
    ?>
</div>
<div class="error">
    <?php
    if (isset($error)) {
        foreach ($error as $e) {
            echo $e;
        }
    }
    ?>
</div>