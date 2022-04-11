<?php namespace action\ask_confirmation;

require_once 'interface.php';
use const \actions\ON_CONTACT;

require_once CORMORANT_DIR . 'core/contact/contact.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';

const RUN = __NAMESPACE__ . '\run';

// This status is telling that Contact Form 7 has been sent normally and 
// the Flamingo gets valid contact form data.
const CF7_STATUS_OK = 'mail_sent';

function init()
{
    add_action(ON_CONTACT, RUN);
}

/**
 * Composes the `Contact` from submitted Contact Form 7 data and sends the 
 * confirmation email with `contact/confirmation-email.php` if the `Contact`
 * confirmation is needed.
 *
 * The Flamingo hook passes a contact form data to related actions and here we
 * working as middleware.
 *
 * After the form data processing, we must to return it unchanged for further
 * use by the Flamingo filters.
 *
 * @see wp-content/plugins/flamingo/includes/class-inbound-message.php
 */
function run(array $form_data): array
{
    // Something is wrong, but it is not our war.
    if (CF7_STATUS_OK !== $form_data['status'])
        return $form_data;

    try
    {
        $email = email($form_data);
        $contact = \contact\by_email($email);
        $contact->ask_confirmation();
    }
    catch (\err\No_Contact $err)
    {
        error_log($err->getMessage());
    }
    finally
    {
        return $form_data;
    }
}

function email($form_data)
{
    return filter_var($form_data['from_email'], FILTER_VALIDATE_EMAIL);
}
