<?php
/**
 * @Author  Chad Windnagle
 * @Project mod_retailers
 * Date: 8/24/15
 */

defined('_JEXEC') or die;

$helper = new modRetailersHelper();

// only load the JS stuff if we don't have the location already
if (! $helper->geoIsAvailable()) {
    $doc = JFactory::getDocument();
    $doc->addScript(JUri::root() . '/modules/mod_retailers/assets/js/retailers.js');
    $doc->addScriptDeclaration('Retailers.JGeoPoll();');
}

?>
<div id="quick-retailers">
    <?php if ($helper->geoIsAvailable()): ?>

    <?php else: ?>

    <?php endif; ?>
</div>

