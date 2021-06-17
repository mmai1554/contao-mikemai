<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Tierchen
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'mikemai',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    'mikemai\Tierchen' => 'system/modules/Tierchen/classes/Tierchen.php',
    'mikemai\TierchenVoter' => 'system/modules/Tierchen/classes/TierchenVoter.php',
    'mikemai\TierchenRanking' => 'system/modules/Tierchen/classes/TierchenRanking.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'wrong_page' => 'system/modules/Tierchen/templates',
	'tierchen_voter' => 'system/modules/Tierchen/templates',
    'tierchen_ranking' => 'system/modules/Tierchen/templates',
));
