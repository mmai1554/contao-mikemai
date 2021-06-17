<?php

if (!defined('INCLUDES_DIR')) {
    define('INCLUDES_DIR', '../../includes/');
}
require_once INCLUDES_DIR . 'config.php';

return AF::displayPageTier(Tierchen::TIER_POLIZEIPUDEL);