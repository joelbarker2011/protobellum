<?php
namespace Protobellum;

/**
 * Collect all battle messages and convert them to JSON
 */
class Herald
{
    private static $Output = [];
    private $army;
    private $color;

    /**
     * Constructor
     *
     * @param   Army    $army   An army for this Herald to join
     *
     * @return  void
     */
    public function __construct(Army $army)
    {
        $this->army     = $army;

        $randomHex      = md5($army->name);
        $this->color    = '#' . substr($randomHex, 0, 6);

        return;
    }

    /**
     * Prepare a message for later transmission
     *
     * @param   string  $message    (Optional) A message to transmit
     *
     * @return  void
     *
     * If $message is omitted, other army stats will still be prepared for transmission.
     */
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

    /**
     * Emit all pending message (by echoing)
     *
     * @return void
     */
    public function flush()
    {
        if (! empty(self::$Output)) {
            echo json_encode(self::$Output);
        }
        self::$Output = [];

        return;
    }

    /**
     * Flush all message before the object is destroyed
     */
    public function __destruct()
    {
        $this->flush();
    }
}
