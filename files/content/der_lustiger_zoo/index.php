<?php

if (!defined('INCLUDES_DIR')) {
    define('INCLUDES_DIR', '../../includes/');
}
require_once INCLUDES_DIR . 'config.php';

$objPage = AF::getPageDefault('Der lustiger Zoo')->addStyle('jetzt/der_lustiger_zoo/zoo.css');
Registry::getSmarty()->assign('arrRanking', Tierchen::getRanking()->arrList);
$objPage->addContentSmarty('der_lustiger_zoo/index.tpl');
$objPage->addContentSmarty('der_lustiger_zoo/ranking.tpl');
$objPage->setFBLike();
$objPage->setOpenGraph(array(
    'title' => 'Der lustiger Zoo',
    'image' => MI_URL_ROOT . 'jetzt/der_lustiger_zoo/zoo.gif',
    'type' => 'article'
));
// Title('Der lustige Zoo', 'article', $image, $url, $site_name);
return $objPage->display();