<?php
/**
 * Used in template field views.
 */

require_once CORMORANT_DIR . 'core/contact/shortcodes/utils.php';
const SHORTCODE = '\shortcodes\shortcode';
const META_SHORTCODE = '\shortcodes\meta_shortcode';

require_once CORMORANT_DIR . 'core/contact/shortcodes/common.php';
use const \shortcodes\BASIC_KEYS;
use const \shortcodes\META_KEYS;

require_once CORMORANT_DIR . 'core/contact/shortcodes/confirmation-link.php';
use const \shortcodes\CONFIRMATION_LINK;

const SPACE = ' ';

function default_shortcodes()
{
    $basic_shortcodes = array_map(SHORTCODE, BASIC_KEYS);
    $meta_shortcodes = array_map(META_SHORTCODE, META_KEYS);
    return implode(SPACE, array_merge($basic_shortcodes, $meta_shortcodes));
}

function confirmation_link_shortcode()
{
    return CONFIRMATION_LINK;
}
