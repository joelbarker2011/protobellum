<?php
namespace Protobellum;

class Herald
{
    private $army;
    private $color;

    public function __construct(Army $army)
    {
        $this->army     = $army;

        $randomHex      = md5(spl_object_hash($this));
        $this->color    = '#' + substr($randomHex, 6);

        return;
    }

    public function announce($message = null)
    {
        $json = json_encode([
            'army'          => $this->army->name,
            'troops'        => $this->army->troops,
            'surrendered'   => $this->army->surrendered,
            'color'         => $this->color,
            'message'       => $message,
        ]);

        echo $json;

        return;
    }
}
