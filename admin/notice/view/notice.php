<?php namespace view;

function notice($text)
{
    ?>
    <div class="error notice is-dismissible">
        <p><?php _e($text, 'cormorant_textdomain'); ?></p>
    </div>
    <?php
}
