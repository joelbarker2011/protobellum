<?php
namespace Protobellum;

trait BattleCryTrait
{
    private $herald;

    private static $VictoryCry      = 'Victory to the mighty!';
    private static $DirgeOfDefeat   = 'Alas! The battle is lost!';
    private static $Surrender       = 'We surrender!';

    protected function rejoice()
    {
        $this->herald->announce(self::$VictoryCry);
    }

    protected function wallow()
    {
        $this->herald->announce(self::$DirgeOfDefeat);
    }

    protected function parley()
    {
        $this->herald->announce(self::$Surrender);
    }
}
