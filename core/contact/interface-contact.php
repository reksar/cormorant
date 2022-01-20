<?php

interface Contact
{
    public function is_confirmed(): bool;
    public function email(): string;
    public function token(): string;
}
