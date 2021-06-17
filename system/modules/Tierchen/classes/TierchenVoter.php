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

use Contao\Form;
use Contao\Input;
use FOS\HttpCacheBundle\CacheManager;

/**
 * Class Tierchen
 *
 * @copyright  Mike Mai 2013
 * @author     Mike Mai
 * @package    Devtools
 */
class TierchenVoter extends \Module {


    /**
     * @var null|Tierchen
     */
    public $objTierchen = null;
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'tierchen_voter';

    public function generate() {
        $this->objTierchen = new Tierchen();
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Vote Button fuer das Tier ###';
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


        $tier = $this->getTierByPage();

        if (null === $tier) {
            $this->Template->setName('wrong_page');
            return;
        }

        $this->Template->tier = $tier;
        $this->Template->formSubmitted = false;
        $this->Template->form = str_replace('##TIER##', $this->Template->tier, Form::getForm(2));

        if ($this->isFormSubmitted()) {
            $tiername = $this->getFormdata('tier');
            $anzahl = $this->getFormdata('anzahl');
            $this->objTierchen->addVote($tiername, $anzahl);
            $this->resetForm();
            $this->Template->formSubmitted = true;
            $this->Template->stimmtext = $this->getTextByStimmen($this->objTierchen->getCount($tier));
        }

    }

    /**
     * @return mixed|string|null
     */
    protected function getTierByPage() {
        global $objPage;
        $arrClass = explode(" ", $objPage->cssClass);
        foreach ($arrClass as $class) {
            if (array_key_exists($class, $this->objTierchen->arrTiere)) {
                return $class;
            }
        }
        return null;
    }

    protected function isFormSubmitted() {
        return $this->getFormdata('FORM_SUBMIT') == 'form_2';
    }

    protected function getFormdata($name) {
        return Input::post($name);
    }

    protected function resetForm() {
        $fields = [
            'FORM_SUBMIT',
            'tier',
            'anzahl'
        ];
        foreach ($fields as $field) {
            Input::setPost($field, null);
            unset($_SESSION['FORM_DATA'][$field]);
        }
    }

    /**
     * @param $anzahl
     * @return string
     */
    protected function getTextByStimmen($anzahl) {
        $anzahl = $anzahl + 0;
        if ($anzahl == 0) {
            return 'Dank Ihnen hat das arme Tier hat nun keine einzige Stimme!';
        }

        if ($anzahl == 1) {
            return 'Dank Ihnen hat das Tier eine ganze Stimme. Naja, was will man mehr?';
        }
        if ($anzahl < 0) {
            return sprintf('Dank Ihnen hat das Tier jetzt %s negative Stimmen. Was soll das denn? Was sind negative Stimmen? Warum macht man sowas mit Tieren?', $anzahl);
        }
        return sprintf('Das Tier hat jetzt satte %s Stimmen!', $anzahl);

    }


}
