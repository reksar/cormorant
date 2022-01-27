<?php namespace view;

function settings()
{
    ?>
    <div class="wrap">
        <h1>Cormorant plugin settings</h1>
        <p>
            The Cormorant plugin adds the <em>"confirmed"</em> tag to a
            Flamingo contact after e-mail confirmation.
        </p>
        <form method="post" action="options.php">
            <?php
            settings_fields(\settings\GROUP);
            do_settings_sections(\settings\PAGE_SLUG);
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
