<div class="messages">
    <div class="info-message">
        <?php
        if (isset($info)) {
            foreach ($info as $i) {
                echo $i;
            }
        }
        ?>
    </div>
    <div class="error-message">
        <?php
        if (isset($error)) {
            foreach ($error as $e) {
                echo $e;
            }
        }
        ?>
    </div>
</div>