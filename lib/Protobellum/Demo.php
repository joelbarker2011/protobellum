<?php
namespace Protobellum;

class Demo
{
    protected $armies = [];

    public function __construct()
    {
        $this->armies[] = new Army('Ravens of Doom',    rand(1000, 10000));
        $this->armies[] = new Army('Lumbering Sloths',  rand(1000, 10000));

        return;
    }

    public function wageWar()
    {
        while (count($this->armies) > 1) {
            $this->doBattle();
        }

        return;
    }

    public function doBattle()
    {
        if (! $this->runSanityChecks()) {
            return;
        }

        $attacker   = $this->getNextArmy();
        $victim     = $this->getNextArmy($attacker);
        
        $attacker->attack($victim);

        $attacker->muster();
        $victim->muster();

        if ($attacker->surrendered || $victim->surrendered) {
            $this->armies = array_filter($this->armies, function ($army) { ! $army->surrendered; });
        }

        return;
    }

    public function isOver()
    {
        count($this->armies) < 2;
    }

    protected function runSanityChecks()
    {
        // make sure there are no duplicate armies
        $this->armies = array_unique($this->armies, SORT_REGULAR);

        // make sure there are multiple armies left
        if ($this->isOver()) {
            trigger_error('There are not enough armies to wage war!', E_USER_ERROR);
            return false;
        }

        // all checks passed!
        return true;
    }

    protected function getNextArmy(Army $excluded = null)
    {
        $candidate = null;

        do {
            $numberOfArmies = count($this->armies);
            $candidate      = $this->armies[ rand(0, $numberOfArmies - 1) ];
        } while ($candidate == $excluded);
        
        return $candidate;
    }
}
