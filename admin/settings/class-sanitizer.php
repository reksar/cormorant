<?php namespace settings;

define('SANITIZERS', glob(__DIR__ . '/sanitize/*.php'));

foreach (SANITIZERS as $sanitizer)
    require_once $sanitizer;

class Sanitizer
{
    private array $sanitizers;

    public function __construct()
    {
        $this->sanitizers = array_merge(...array_map(
            'self::sanitizer', SANITIZERS));
    }

    public function __invoke(array $settings): array
    {
        return array_merge(...array_map(
            [$this, 'setting'], array_keys($settings), $settings));
    }

    private function setting($name, $value)
    {
        return [$name => $this->sanitizers[$name]($value)];
    }

    private static function sanitizer($sanitizer_path)
    {
        $name = pathinfo($sanitizer_path)['filename'];
        $function = "sanitize\\$name";
        return [$name => $function];
    }
}
