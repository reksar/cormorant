<?php namespace flamingo\action;

require_once CORMORANT_DIR . 'core\contact\interface-contact.php';
require_once CORMORANT_DIR . 'core\contact\class-confirmation-email.php';
require_once CORMORANT_DIR . 'core\flamingo\class-contact.php';

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
        if (STATUS_OK === $form_data['status']) self::process($form_data);

        return $form_data;
    }

    /*
     * Compose the `Contact` from form data, build and send the 
     * `Confirmation_Email`.
     */
    private static function process(array $form_data)
    {
        $contact = new \flamingo\Contact($form_data);
        $contact->is_confirmed() ?: (new \Confirmation_Email($contact))->send();
    }
}
