<?php namespace actions;

// When the Flamingo gets an incoming contact from Contact Form 7.
const ON_CONTACT = 'flamingo_add_inbound';

// Cormorant fires this event when a contact has been confirmed.
// See `Contact::confirm()` at `core/contact/class-contact.php`.
const ON_CONFIRM = 'cormorant_confirmed';

// When an user follows the confirmation link from email and the WP GETs 
// a request with the `WP_ACTION`.
const WP_ACTION = 'confirm_email';
// Default action. For not authorized users.
const ON_CONFIRMATION = 'admin_post_nopriv_' . WP_ACTION;
// When some authorized WP user confirms email.
const ON_CONFIRMATION_AUTH = 'admin_post_' . WP_ACTION;

const ON_CRON_DAILY = 'flamingo_daily_cron_job';

const TOKEN_URL_PARAM = 'token';
