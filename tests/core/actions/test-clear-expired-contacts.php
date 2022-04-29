<?php

require_once CORMORANT_DIR . 'core/actions/interface.php';
// The `action\clear_expired_contacts` will be invoked on this event.
use const \actions\ON_CRON_DAILY;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED;

require_once \test\ROOT_DIR . '/utils/contact.php';

class Test_Clear_Expired_Contacts extends WP_UnitTestCase
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

    static int $contacts_total = 0;

    static function setUpBeforeClass(): void
    {
        self::$contacts_total =
            count(self::CONFIRMED_CONTACTS) +
            count(self::UNCONFIRMED_CONTACTS);
    }

    function setUp(): void
    {
        \utils\contact\add_all([
            ...self::UNCONFIRMED_CONTACTS,
            ...self::CONFIRMED_CONTACTS,
        ], self::GENERATE_EMAILS);
    }

    function tearDown(): void
    {
        \utils\contact\remove_all();
    }

    /**
     * The default value of `days_to_confirm` is 0.
     * @see `tests/settings/test-default-value.php`.
     *
     * All unconfirmed contacts will be found in this case by
     * `contact\find_unconfirmed_in()`.
     * @see `Test_Find_Unconfirmed_Contacts::test_gives_all_unconfirmed_contacts_by_default()`.
     *
     * But the `action\clear_expired_contacts` do nothing in this case.
     * @see `run()` in `cormorant/core/actions/clear-expired-contacts.php`.
     *
     * Thus no contacts should be deleted.
     */
    function test_deletes_nothing_by_default()
    {
        do_action(ON_CRON_DAILY);
        $this->assertEquals(self::$contacts_total, \utils\contact\count());
    }

    function test_deletes_nothing_if_all_unconfirmed_is_up_to_date()
    {
        set_days_to_confirm(31);
        do_action(ON_CRON_DAILY);
        $this->assertEquals(self::$contacts_total, \utils\contact\count());
    }

    function test_deletes_all_but_today_if_days_to_confirm_1()
    {
        set_days_to_confirm(1);
        do_action(ON_CRON_DAILY);
        $should_be_deleted = [
            'Added Yesterday',
            'Added 2 Days ago',
            'Added a Week ago',
            'Added a Month ago',
        ];
        $this->assertEquals(
            self::count_excluding($should_be_deleted),
            \utils\contact\count());
    }

    function test_deletes_older_than_1_day_if_days_to_confirm_2()
    {
        set_days_to_confirm(2);
        do_action(ON_CRON_DAILY);
        $should_be_deleted = [
            'Added 2 Days ago',
            'Added a Week ago',
            'Added a Month ago',
        ];
        $this->assertEquals(
            self::count_excluding($should_be_deleted),
            \utils\contact\count());
    }

    function test_deletes_older_than_2_days_if_days_to_confirm_3()
    {
        set_days_to_confirm(3);
        do_action(ON_CRON_DAILY);
        $should_be_deleted = [
            'Added a Week ago',
            'Added a Month ago',
        ];
        $this->assertEquals(
            self::count_excluding($should_be_deleted),
            \utils\contact\count());
    }

    /**
     * WARN: Does not check names! Only counts.
     */
    static function count_excluding(array $exclude): int
    {
        return self::$contacts_total - count($exclude);
    }
}

function set_days_to_confirm(int $days)
{
    assert(update_option(\settings\NAME, [
        'days_to_confirm' => $days,
    ]));
}
