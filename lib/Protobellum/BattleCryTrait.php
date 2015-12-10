<?php
namespace Protobellum;

trait BattleCryTrait
{
    private $herald;

    private static $VictoryCry      = 'Victory to the mighty!';
    private static $DirgeOfDefeat   = 'Alas! The battle is lost!';
    private static $Surrender       = 'We surrender!';

    /**
     * Use the herald to emit a victorious message
     *
     * @return  void
     */
    protected function rejoice()
    {
        $this->herald->announce(self::$VictoryCry);
    }

    /**
     * Use the herald to emit a sad message of defeat
     *
     * @return  void
     */
    protected function wallow()
    {
        $this->herald->announce(self::$DirgeOfDefeat);
    }

    /**
     * Use the herald to emit a plea for merciful surrender
     *
     * @return  void
     */
    protected function parley()
    {
        $this->herald->announce(self::$Surrender);
    }
}
