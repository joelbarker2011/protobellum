<?php
namespace Protobellum;

class Herald
{
    private static $Output = [];
    private $army;
    private $color;

    public function __construct(Army $army)
    {
        $this->army     = $army;

        $randomHex      = md5($army->name);
        $this->color    = '#' . substr($randomHex, 0, 6);

        return;
    }

    public function announce($message = null)
    {
        self::$Output[] = [
            'army'          => $this->army->name,
            'troops'        => $this->army->troops,
            'surrendered'   => $this->army->surrendered,
            'color'         => $this->color,
            'message'       => $message,
        ];

        return;
    }

    public function flush()
    {
        if (! empty(self::$Output)) {
            echo json_encode(self::$Output);
        }
        self::$Output = [];

        return;
    }

    public function __destruct()
    {
        $this->flush();
    }
}
