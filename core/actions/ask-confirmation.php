<?php namespace action\ask_confirmation;

require_once CORMORANT_DIR . 'core/contact/class-contact.php';
require_once CORMORANT_DIR . 'core/contact/confirmation-email.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';

// This status is telling that Contact Form 7 has been sent normally and 
// the Flamingo gets valid contact form data.
const CF7_STATUS_OK = 'mail_sent';

// When the Flamingo gets an incoming contact.
const ON_CONTACT = 'flamingo_add_inbound';

function init()
{
    add_action(ON_CONTACT, '\action\ask_confirmation\run');
}

/* 
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
        send_email_to_contact($form_data);
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

function send_email_to_contact($form_data)
{
    $email = $form_data['from_email'] ?? '';
    $contact = new \Contact($email);
    if (! $contact->is_confirmed())
        \contact\confirmation_email\send($contact);
}
