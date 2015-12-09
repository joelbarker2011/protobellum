<?php
namespace Protobellum;

class Army
{
    use BattleCryTrait;

    private $name           = null;
    private $troops         = 0;        // may be 0..infinity
    private $surrendered    = false;

    /* public methods */

    public function __construct($name, $troops)
    {
        $this->name     = $name;
        $this->troops   = $troops;
    }

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

    public function muster()
    {
        echo "<h6>$this->name</h6>";
        echo "$this->troops<br/>";
        return;
        echo json_encode([
            'name'          => $this->name,
            'troops'        => $this->troops,
            'surrendered'   => $this->surrendered,
        ]);
    }

    public function attack(Army $enemy)
    {
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
    }

    /* private methods */

    private function strength()
    {
        $luck = rand() / getrandmax();      // will be 0..1
        return $luck * $this->troops;
    }

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
    }

    private function demandSurrender($enemy)
    {
        if ($this->troops > ($enemy->troops * $enemy->troops)) {
            $enemy->parley();
            $enemy->surrendered = true;
        }
    }
}
