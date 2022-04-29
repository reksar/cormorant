<?php

require_once CORMORANT_DIR . 'core/contact/contact.php';
use function \contact\find_unconfirmed_in;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED;

require_once \test\ROOT_DIR . '/utils/contact.php';

class Test_Find_Unconfirmed_Contacts extends WP_UnitTestCase
{
    // Name, age, array of tags
    const UNCONFIRMED_CONTACTS = [
        ['Added Today too'],
        ['Added Today'],
        ['Added Yesterday', 1],
        ['Added 2 Days ago', 2],
        ['Added a Week ago', 7, ['some-tag']],
        ['Added a Month ago', 30, ['some-tag', 'unconfirmed']],
    ];
    // NOTE: uses default confirmed tag name same as slug.
    // NOTE: tags like 'unconfirmed' have no effect.
    const CONFIRMED_CONTACTS = [
        ['Confirmed Today', 0, [CONFIRMED, 'cormorant-unconfirmed']],
        ['Confirmed Yesterday', 1, [CONFIRMED, 'unconfirmed']],
        ['Confirmed 2 Days ago', 2, [CONFIRMED, 'not-confirmed']],
        ['Confirmed a Month ago', 30, [CONFIRMED, 'a', 'b', 'c']],
    ];

    const GENERATE_EMAILS = true;

    static int $unconfirmed_total = 0;

    static function setUpBeforeClass(): void
    {
        \utils\contact\add_all([
            ...self::UNCONFIRMED_CONTACTS,
            ...self::CONFIRMED_CONTACTS,
        ], self::GENERATE_EMAILS);

        self::$unconfirmed_total = count(self::UNCONFIRMED_CONTACTS);
    }

    function test_all_contacts_are_added()
    {
        $total = self::$unconfirmed_total + count(self::CONFIRMED_CONTACTS);
        $this->assertEquals($total, \utils\contact\count());
    }

    /**
     * The default value of `days_to_confirm` is 0.
     * @see `tests/settings/test-default-value.php`.
     */
    function test_gives_all_unconfirmed_contacts_by_default()
    {
        $days_to_confirm = 0;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertEquals(self::$unconfirmed_total, count($contacts));
    }

    function test_unconfirmed_in_1_day_excludes_today()
    {
        $days_to_confirm = 1;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $total = self::$unconfirmed_total - 2;
        $this->assertEquals($total, count($contacts));
    }

    function test_unconfirmed_in_2_days_excludes_today_and_yesterday()
    {
        $days_to_confirm = 2;
        $contacts = find_unconfirmed_in($days_to_confirm);
        $this->assertFalse(containsName($contacts, 'Added Today'));
        $this->assertFalse(containsName($contacts, 'Added Today too'));
        $this->assertFalse(containsName($contacts, 'Added Yesterday'));
        $total = self::$unconfirmed_total - 3;
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
        $total = self::$unconfirmed_total - 4;
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
        $total = self::$unconfirmed_total - 4;
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
        $total = self::$unconfirmed_total - 5;
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
