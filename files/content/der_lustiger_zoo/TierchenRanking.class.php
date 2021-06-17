<?php

class TierchenRanking {

    public $intMax = 0;
    public $strMaxIndex = '';
    
    public $arrRanking = array(); // Rankingliste absteigernd sortiert
    public $arrList = array();
    
    function __construct() {
        
    }
    
    function getRanking() {
        $arrList = $this->arrRanking;
        array_multisort(array_values($arrList), SORT_DESC, array_keys($arrList), SORT_ASC, $arrList);        
        return $arrList;
    }
    
    
    
    
}