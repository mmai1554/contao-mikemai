<?php

class Tierchen {

    const TIERDATEI = 'jetzt/der_lustiger_zoo/votedat.tpl'; // TPL Dateien sind per htaccess geschützt

    public $strPath = '';
    protected $arrData = array(); // Hier stehen die Tierchen und deren Stimmen 

    const TIER_AROMAHASE = 'aromahase';
    const TIER_BLUTIGE_LEBER_FUCHS = 'blutigeleberfuchs';    
    const TIER_DONUTSCHAF = 'donutschaf';    
    const TIER_DUMMER_DINO = 'dummerdino';    
    const TIER_HIRSCH = 'hirsch';    
    const TIER_POLIZEIPUDEL = 'polizeipudel';
    const TIER_TARNELEFANT = 'tarnelefant';
    const TIER_SCHAEFERHUND = 'schaeferhund';
    const TIER_SCHNECKE = 'schnecke';    
    const TIER_STANGULATIONSPFERDCHEN = 'strangulationspferdchen';

    protected $strTier = ''; // Das Aktuelle TIER
    protected $arrInfo = array();
    protected $bExists = false;

    function __construct($tier) {
        $this->arrInfo = array(
            self::TIER_AROMAHASE => array('name' => 'Der Aromahase', 'tpl' => 'aromahase.tpl', 'kom' => 'Der Aromahase - ein lustiger Geselle'),
            self::TIER_BLUTIGE_LEBER_FUCHS => array('name' => 'Der Blutige Leber Fuchs', 'tpl' => 'blutigeleberfuchs.tpl', 'kom' => 'Blutig und Roh - Schlimm!'),
            self::TIER_DONUTSCHAF => array('name' => 'Das Donutschaf', 'tpl' => 'donutschaf.tpl', 'kom' => 'Hmm Gibt es etwas leckerereres als ein Schaf, das Donuts isst?'),
            self::TIER_DUMMER_DINO => array('name' => 'Trichetrantrops Rex', 'tpl' => 'dummerdino.tpl', 'kom' => 'Trichetrantrrops Rex - Workloch ausgestorben?'),
            self::TIER_HIRSCH => array('name' => 'Der Hirsch', 'tpl' => 'hirsch.tpl' ,'kom' => 'Der Vater von Bambi und vielleicht auch die Mutter'),
            self::TIER_POLIZEIPUDEL => array('name' => 'Polizeipudel', 'tpl' => 'polizeipudel.tpl', 'kom' => 'Tatüü Tataa der Polizeipudel ist weg'),
            self::TIER_TARNELEFANT => array('name' => 'Der Tarnelefant', 'tpl' => 'tarnelefant.tpl', 'kom' => 'El Enfant Ele - Nicht sichtbar aber gefühlt da!'),
            self::TIER_SCHAEFERHUND => array('name' => 'Schäferhund reinrassig 1a', 'tpl' => 'schaeferhund.tpl', 'kom' => 'Hauptsache reine Rasse'),
            self::TIER_SCHNECKE => array('name' => 'Die Schnecke', 'tpl' => 'schnecke.tpl', 'kom' => 'von Null auf Hundert gar nicht'),
            self::TIER_STANGULATIONSPFERDCHEN => array('name' => 'Strangulationspferdchen', 'tpl' => 'strangulationspferdchen.tpl', 'kom' => 'Ein neugieriges Kerlchen dieses Haustier'),
        );
        if (!$tier) {
            throw new Exception('Tier ist leer');
        }
        if (!isset($this->arrInfo[$tier])) {
            throw new Exception('Tier "' . $tier . '" nicht gefunden');
        }
        $this->strPath = MI_DOCROOT.self::TIERDATEI;
        $this->strTier = $tier;
    }
    
    public static function getRanking() {
        $objTier = new Tierchen(self::TIER_AROMAHASE); // Muss sein
        $objTier->loadData();
        $objRanking = new TierchenRanking();        
        foreach($objTier->arrInfo as $tier => $row) {
            $objRanking->arrRanking[$tier] = isset($objTier->arrData[$tier]) ? ($objTier->arrData[$tier] + 0) : 0;
            if ($objRanking->arrRanking[$tier] > $objRanking->intMax) {
                $objRanking->intMax = $objRanking->arrRanking[$tier];
                $objRanking->strMaxIndex = $tier;                
            }
            // $arrSortCol[] = $objRanking->arrRanking[$tier];
        }
        // Ausführliche Liste aufbauen:
        foreach($objRanking->arrRanking as $tier => $votes) {
            $objRanking->arrList[] = array(
                'tier' => $tier,
                'name' => $objTier->arrInfo[$tier]['name'],
                'votes' => $votes,
                'width' => $objRanking->intMax == 0 ? 0 : floor($votes * (400/$objRanking->intMax)),
                'link_zum_tier' => MI_URL_ROOT . 'jetzt/der_lustiger_zoo/'.$tier.'.php',
                'kom' => $objTier->arrInfo[$tier]['kom'],
                'more_votes' => ($votes === 0 || ($objRanking->intMax / 10) >= $votes ) ? true : false
            );
        }
        return $objRanking;
    }
    
    

    function getName() {
        return $this->arrInfo[$this->strTier]['name'];
    }

    function getTemplate() {
        return 'der_lustiger_zoo/' . $this->arrInfo[$this->strTier]['tpl'];
    }

    function getId() {
        return $this->strTier;
    }

    function renderMarkupVote() {
        $tier = $this->strTier;
        $objSmarty = Registry::getSmarty();
        $objSmarty->assign('tier', $tier);
        $objSmarty->assign('target', MI_URL_ROOT. 'jetzt/der_lustiger_zoo/rate.php');
        return $objSmarty->fetch('der_lustiger_zoo/diervoting.js');
    }

    /**
     * Lädt das Dataarray (oder legt es an)
     * @return array
     */
    protected function loadData() {
        $objFile = new MIFile();
        if (!is_file($this->strPath)) {
            $bSucc = touch($this->strPath);
            if (!$bSucc) {
                throw new Exception('Datei ' . $this->strPath . ' konnt nicht angelegt werden');
            }
        }
        $this->arrData = unserialize(file_get_contents($this->strPath));
        return $this->arrData;
    }

    protected function saveData() {
        file_put_contents($this->strPath, serialize($this->arrData));
    }

    public function addVote() {
        if (!$this->strTier) {
            throw new Exception();
        }
        $this->loadData();
        $this->arrData[$this->strTier]++;
        $this->saveData();
    }

    /**
     * Anzahl der Votes für Tierchen
     * @param string $tier
     * @return integer 
     */
    public function getCount() {
        $tier = $this->strTier;
        $this->loadData();
        return isset($this->arrData[$tier]) ? ($this->arrData[$tier] + 0) : 0;
    }

}