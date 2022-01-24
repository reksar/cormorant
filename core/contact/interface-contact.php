<?php

interface Contact
{
    public function id(): int;
    public function email(): string;
    public function token(): string;
    public function is_confirmed(): bool;
    public function confirm();
}
