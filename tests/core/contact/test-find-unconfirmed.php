<?php

require_once CORMORANT_DIR . 'core/contact/contact.php';
use function \contact\find_unconfirmed_in;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED;

require_once TESTS_DIR . '/utils/contact.php';

const UNCONFIRMED_CONTACTS = [
    ['c-1@mail.my', 'Added Today too'],
    ['c0@mail.my', 'Added Today'],
    ['c1@mail.my', 'Added Yesterday', 1],
    ['c2@mail.my', 'Added 2 Days ago', 2],
    ['c3@mail.my', 'Added a Week ago', 7, ['some-tag']],
    ['c4@mail.my', 'Added a Month ago', 30, ['some-tag', 'unconfirmed']],
];
define('UNCONFIRMED_TOTAL', count(UNCONFIRMED_CONTACTS));

// NOTE: uses default confirmed tag name same as slug.
// NOTE: tags like 'unconfirmed' have no effect.
const CONFIRMED_CONTACTS = [
    ['c5@mail.my', 'Confirmed Today', 0, [CONFIRMED, 'cormorant-unconfirmed']],
    ['c6@mail.my', 'Confirmed Yesterday', 1, [CONFIRMED, 'unconfirmed']],
    ['c7@mail.my', 'Confirmed 2 Days ago', 2, [CONFIRMED, 'not-confirmed']],
    ['c8@mail.my', 'Confirmed a Month ago', 30, [CONFIRMED, 'a', 'b', 'c']],
];

const ALL_CONTACTS = [...UNCONFIRMED_CONTACTS, ...CONFIRMED_CONTACTS];
define('CONTACTS_TOTAL', count(ALL_CONTACTS));

class Test_Find_Unconfirmed_Contacts extends WP_UnitTestCase
{
    static function setUpBeforeClass(): void
    {
        foreach (ALL_CONTACTS as $args)
            \utils\contact\add(...$args);
    }

    function test_all_contacts_are_added()
    {
        $this->assertEquals(CONTACTS_TOTAL, \utils\contact\total());
    }

    /**
     * The default value of `days_to_confirm` is 0.
     * @see `tests/settings/test-default-value.php`.
     */
    function test_gives_all_unconfirmed_contacts_by_default()
    {
        $days_to_confirm = 0;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertEquals(UNCONFIRMED_TOTAL, count($contacts));
    }

    function test_unconfirmed_in_1_day_excludes_today()
    {
        $days_to_confirm = 1;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $total = UNCONFIRMED_TOTAL - 2;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_2_days_excludes_today_and_yesterday()
    {
        $days_to_confirm = 2;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $total = UNCONFIRMED_TOTAL - 3;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_3_days_excludes_up_to_2_days_old()
    {
        $days_to_confirm = 3;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $this->assertFalse(containsName($contacts, 'Added 2 Days ago'));
        $total = UNCONFIRMED_TOTAL - 4;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_7_days_does_not_excludes_a_weekly()
    {
        $days_to_confirm = 7;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $this->assertFalse(containsName($contacts, 'Added 2 Days ago'));
        $total = UNCONFIRMED_TOTAL - 4;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_8_days_excludes_a_weekly()
    {
        $days_to_confirm = 8;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $this->assertFalse(containsName($contacts, 'Added 2 Days ago'));
        $this->assertFalse(containsName($contacts, 'Added a Week ago'));
        $total = UNCONFIRMED_TOTAL - 5;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_31_days_excludes_a_monthly()
    {
        $days_to_confirm = 31;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $this->assertFalse(containsName($contacts, 'Added 2 Days ago'));
        $this->assertFalse(containsName($contacts, 'Added a Week ago'));
        $this->assertFalse(containsName($contacts, 'Added a Month ago'));
        $total = 0;
        $this->assertEquals($total, count($contacts));
    }
}

function containsName(array $contacts, $name)
{
    return (bool) array_filter($contacts,

        function($contact) use ($name) {
            return $contact->name() == $name;
        });
}
