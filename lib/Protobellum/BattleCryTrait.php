<?php
namespace Protobellum;

trait BattleCryTrait
{
    private static $VictoryCry      = 'Victory to the mighty!';
    private static $DirgeOfDefeat   = 'Alas! The battle is lost!';
    private static $Surrender       = '<br/>We surrender!';

    protected function rejoice()
    {
        echo self::$VictoryCry;
    }

    protected function wallow()
    {
        echo self::$DirgeOfDefeat;
    }

    protected function parley()
    {
        echo self::$Surrender;
    }
}
