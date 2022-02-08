<?php namespace action\clear_expired_contacts;

require_once CORMORANT_DIR . 'core/flamingo.php';

const ON_CRON_DAILY = 'flamingo_daily_cron_job';

function init()
{
    add_action(ON_CRON_DAILY, '\action\clear_expired_contacts\run');
}

function run()
{
    array_walk(\flamingo\expired_contacts(),

        function($contact) {
            $contact->delete();
        });
}
