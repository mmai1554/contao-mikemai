<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mmai
 * Date: 05.10.13
 * Time: 13:44
 * To change this template use File | Settings | File Templates.
 */

namespace mikemai;


use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Tierchen {

    const TIER_AROMAHASE = 'aromahase';
    const TIER_BLUTIGE_LEBER_FUCHS = 'blutigeleberfuchs';
    const TIER_DONUTSCHAF = 'donutschaf';
    const TIER_DUMMER_DINO = 'trichetantropsrex';
    const TIER_HIRSCH = 'hirsch';
    const TIER_POLIZEIPUDEL = 'polizeipudel';
    const TIER_TARNELEFANT = 'tarnelefant';
    const TIER_SCHAEFERHUND = 'schaeferhund';
    const TIER_SCHNECKE = 'schnecke';
    const TIER_STANGULATIONSPFERDCHEN = 'strangulationspferdchen';

    public $arrTiere = array(
        self::TIER_AROMAHASE => 'Der Aromahase',
        self::TIER_BLUTIGE_LEBER_FUCHS => 'Der Blutige Leber Fuchs',
        self::TIER_DONUTSCHAF => 'Das Donutschaf',
        self::TIER_DUMMER_DINO => 'Trichetrantops Rex',
        self::TIER_HIRSCH => 'Hirsch',
        self::TIER_POLIZEIPUDEL => 'Der Polizeipudel',
        self::TIER_TARNELEFANT => 'Der Tarnelefant',
        self::TIER_SCHAEFERHUND => 'Der Schäferhund',
        self::TIER_SCHNECKE => 'Die Schnecke',
        self::TIER_STANGULATIONSPFERDCHEN => 'Das Strangulationspferdchen'
    );

    public $arrVotings = array();

    protected $path = 'system/modules/Tierchen/templates/votings.txt';

    public function addVote($tier, $amount = 1) {
        $this->loadData();
        $this->arrVotings[$tier] = $this->arrVotings[$tier] + $amount;
        $this->saveData();
    }


    /**
     * @return array
     */
    public function loadData() {
        $path = TL_ROOT . '/' . $this->path;
        if (!is_file($path)) {
            if (!touch($path)) {
                throw new FileNotFoundException('Could not create File: ' . $path);
            }
            $this->arrVotings = array();
            return $this->arrVotings;
        } else {
            $this->arrVotings = json_decode(file_get_contents($path), true);
            if (!is_array($this->arrVotings)) {
                $this->arrVotings = [];
            }
            return $this->arrVotings;
        }
    }

    public function saveData() {
        $path = TL_ROOT . '/' . $this->path;
        if (is_file($path)) {
            file_put_contents($path, json_encode($this->arrVotings));
        }
    }

    public function getCount($tier) {
        $this->loadData();
        return isset($this->arrVotings[$tier]) ? (integer)$this->arrVotings[$tier] : 0;
    }


}