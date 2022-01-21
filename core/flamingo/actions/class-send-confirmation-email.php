<?php namespace flamingo\action;

require_once CORMORANT_DIR . 'core/contact/class-confirmation-email.php';
require_once CORMORANT_DIR . 'core/flamingo/class-contact.php';

// This status is telling that Contact Form 7 has been sent normally and 
// the Flamingo gets valid contact form data.
const STATUS_OK = 'mail_sent';

class Send_Confirmation_Email
{
    public function __construct()
    {
        // When the Flamingo processes incoming contact form data.
        // @see wp-content/plugins/flamingo/includes/class-inbound-message.php
        add_action('flamingo_add_inbound', $this);
    }

    /* 
     * The `flamingo_add_inbound` hook passes a contact form data to related 
     * actions and here we working as middleware.
     *
     * After the form data processing, we must to return it unchanged for 
     * further use by the Flamingo filters.
     *
     * @see wp-content/plugins/flamingo/includes/class-inbound-message.php
     */
    public function __invoke(array $form_data): array
    {
        // Something is wrong, but it is not our war.
        if (STATUS_OK !== $form_data['status']) return $form_data;

        try {
            self::send_email_to_contact_from($form_data);
        }
        catch (\flamingo\Err_No_Contact $e) {
            error_log($e->getMessage());
        }
        finally {
            return $form_data;
        }
    }

    private static function send_email_to_contact_from(array $form_data)
    {
        $email = $form_data[''] ?? '';
        $contact = new \flamingo\Contact($email);
        $contact->is_confirmed() ?: (new \Confirmation_Email($contact))->send();
    }
}
