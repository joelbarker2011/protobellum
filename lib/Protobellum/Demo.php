<?php
namespace Protobellum;

/**
 * Encapsulate logic to wage a demonstrative war
 */
class Demo
{
    protected $armies = [];

    /**
     * Randomly generate a beautiful name for our army
     *
     * @return  string  The beautiful name
     */
    private static function GenerateName()
    {
        static $adjectives  = ['Lumbering', 'Berserk', 'Cheerful', 'Pillaging', 'Simpleminded'];
        static $nouns       = ['Sloths', 'Slugbears', 'Watchmakers', 'Barbarians', 'Adventurers'];

        shuffle($adjectives);
        shuffle($nouns);

        return array_pop($adjectives) . ' ' . array_pop($nouns);
    }

    /**
     * Prepare a war. Please exercise discretion.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->armies[] = new Army(self::GenerateName(), rand(1000, 10000));
        $this->armies[] = new Army(self::GenerateName(), rand(1000, 10000));

        return;
    }

    /**
     * Start a war, consisting of a series of battles
     *
     * @return void
     */
    public function wageWar()
    {
        while (count($this->armies) > 1) {
            $this->doBattle();
        }

        return;
    }

    /**
     * Engage in a single battle (one attack and some damage)
     *
     * @return  void
     */
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

    /**
     * Check whether the war is over
     *
     * @return  bool    True if the war is over, else false
     */
    public function isOver()
    {
        return count($this->armies) < 2;
    }

    /**
     * Make sure that there are at least 2 opposing armies, and other checks
     *
     * @return  bool    True if we're ready for war, false if there were problems
     */
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

    /**
     * Pick a random army from those at war
     *
     * @param   Army    $excluded   (optional) Don't pick this army for some reason
     *
     * @return  Army    A random army that isn't $excluded
     */
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
