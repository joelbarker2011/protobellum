<?php
namespace Protobellum;

/**
 * Represents an army and all its attributes
 */
class Army
{
    use BattleCryTrait;

    private $name           = null;
    private $troops         = 0;        // may be 0..infinity
    private $surrendered    = false;

    /* public methods */

    /**
     * Constructor
     *
     * @param   string  $name       The name of this Army
     * @param   int     $troops     The number of troops
     * @param   Herald  $herald     (optional) A Herald object to manage output
     *
     * @return  void
     */
    public function __construct($name, $troops, Herald $herald = null)
    {
        $this->name     = $name;
        $this->troops   = $troops;
        $this->herald   = $herald ? $herald : new Herald($this);

        return;
    }

    /**
     * Utility accessor to allow getting of whitelisted private variables
     *
     * This is a magic method; it should not be called directly.
     *
     * Allowed usage:
     *
     *      $army->name
     *      $army->troops
     *      $army->surrendered
     *      
     * @return  mixed   The private variable
     *
     * Triggers an E_USER_NOTICE error if some other private variable is attempted.
     */
    public function __get($private_var)
    {
        switch ($private_var) {
        case 'name':
        case 'troops':
        case 'surrendered':
            return $this->$private_var;     // magic!
        default:
            trigger_error("Undefined property: $private_var", E_USER_NOTICE);
            return null;
        }
    }

    /**
     * Use the herald to output stats on this army.
     *
     * @return void
     */
    public function muster()
    {
        $this->herald->announce();
        return;
    }

    /**
     * Attack an opposing army.
     *
     * @param   Army    $enemy  An opposing army that will soon be crushed in defeat
     *
     * @return  void
     */
    public function attack(Army $enemy)
    {
        $this->herald->announce("Attack the vile $enemy->name!");

        $victory = $this->strength() > $enemy->strength();

        $this->sustainDamage($victory);
        $enemy->sustainDamage($victory);

        if ($victory) {
            $this->rejoice();
            $this->demandSurrender($enemy);
        } else {
            $this->wallow();
            $enemy->demandSurrender($this);
        }

        return;
    }

    /* private methods */

    /**
     * Get current strength, based on troop levels and luck
     *
     * @return  float   A numeric value representing strength
     */
    private function strength()
    {
        $luck = rand() / getrandmax();      // will be 0..1
        return $luck * $this->troops;
    }

    /**
     * Adjust troop numbers after a conflict
     *
     * @param   bool    $victory    True if we won the battle, else false
     *
     * @return  void
     */
    private function sustainDamage($victory)
    {
        $luck = rand() / getrandmax();      // will be 0..1

        if ($victory) {
            $damage = $luck * sqrt($this->troops);
        } else {
            $damage = $luck * $this->troops;
        }

        $this->troops -= round($damage);
        if ($this->troops <= 0) {
            $this->troops = 0;
            $this->surrendered = true;
        }

        return;
    }

    /**
     * Give up the war
     *
     * @param   Army    $enemy  The army to surrender to
     *
     * Note: Regardless of the $enemy, a surrender applies to all wars we are engaged in.
     */
    private function demandSurrender($enemy)
    {
        if ($this->troops > ($enemy->troops * $enemy->troops)) {
            $enemy->parley();
            $enemy->surrendered = true;
        }
    }
}
