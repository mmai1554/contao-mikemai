<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   mikemai
 * @author    Mike Mai
 * @license   GNU/LGPL
 * @copyright Mike Mai 2013
 */


/**
 * Namespace
 */

namespace mikemai;


/**
 * Class Tierchen
 *
 * @copyright  Mike Mai 2013
 * @author     Mike Mai
 * @package    Devtools
 */
class TierchenRanking extends \Module {


    /**
     * @var null|Tierchen
     */
    public $objTierchen = null;
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'tierchen_ranking';
    /**
     * @var array
     */
    protected $arrVotings = array();

    public function generate() {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Tiere Ranking Liste ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile() {
        $this->objTierchen = new Tierchen();
        $this->objTierchen->loadData();
        $arrRanking = $this->objTierchen->arrVotings;
        arsort($arrRanking);
        $max = 0;
        $max_tier = '';
        // fill arrRanking with all Tierchen and calculate max:
        foreach (array_keys($this->objTierchen->arrTiere) as $tier) {
            if (!array_key_exists($tier, $arrRanking)) {
                $arrRanking[$tier] = 0;
            }
            if ($arrRanking[$tier] > $max_tier) {
                $max = $arrRanking[$tier];
                $max_tier = $tier;
            }
        }
        // build list:
        $arrRankList = array();
        foreach ($arrRanking as $tier => $votes) {

            $arrRankList[] = array(
                'tier' => $tier,
                'name' => $this->objTierchen->arrTiere[$tier],
                'votes' => (integer)$votes,
                'width' => $this->getWidthPercent($votes, $max),
            );

        }
        $this->Template->arrRanking = $arrRankList;
    }

    protected function getWidthPercent($votes, $max) {

        if($votes <= 0) {
            return 0;
        }
        if($max <= 0) {
            return 0;
        }
        return floor($votes * (10 / $max));

    }


}
