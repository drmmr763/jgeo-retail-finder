<?php
/**
 * @Author  Chad Windnagle
 * @Project mod_retailers
 * Date: 8/24/15
 */

defined('_JEXEC') or die;

$helper = new modRetailersHelper();
$doc = JFactory::getDocument();

// only load the JS stuff if we don't have the location already
if (! $helper->geoIsAvailable()) {
    $doc->addScript(JUri::root() . '/modules/mod_retailers/assets/js/retailers.js');
    $doc->addScriptDeclaration('Retailers.JGeoPoll();');
}

$params = JComponentHelper::getParams('com_restonicretailers');

$doc->addScript('https://maps.googleapis.com/maps/api/js?key='.$params->get('gmap_apikey'));

?>
<div class="accordion" id="quick-retailers">
    <?php if ($helper->geoIsAvailable()): ?>
        <?php $retailers = $helper->getRetailers($params->get('limit', 2)); ?>
        <?php $count = 0; ?>
        <?php if(count($retailers)): ?>
            <?php foreach ($retailers as $retailer): ?>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#quick-retailers" href="#tab<?php echo $count; ?>">
                            <?php echo $retailer->location_name; ?>
                        </a>
                    </div>
                    <div id="tab<?php echo $count; ?>" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <?php if ($retailer->location_phone): ?>
                                <p>Phone: <a href="tel:<?php echo $retailer->location_phone; ?>">
                                              <?php echo $retailer->location_phone; ?>
                                          </a>
                                </p>
                            <?php endif; ?>
                            <?php if ($retailer->location_address && $retailer->location_city && $retailer->location_state && $retailer->location_zip): ?>
                                <p>
                                    <?php echo $retailer->location_address; ?>
                                    <br />
                                    <?php echo $retailer->location_city . ", " . $retailer->location_state . " " . $retailer->location_zip; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $count++; ?>
            <?php endforeach; ?>
        <?php endif;?>
    <?php else: ?>
        <p><?php echo $params->get('wait_text', 'Finding Nearby Retailers'); ?><img class="pull-right" src="<?php echo JUri::root(); ?>/images/system/searchLoader.gif" /></p>
    <?php endif; ?>
    <form class="form-inline" id="retailer-lookup" method="post" action="<?php echo JRoute::_('index.php?option=com_restonicretailers'); ?>">
        <fieldset class="locator">
            <input class="required input input-medium" placeholder="Enter zipcode" type="text" name="zip" id="zip">
            <input type="submit" class="btn btn-priamry input-medium" name="submit" id="submit" value="Search Locations" />
        </fieldset>
    </form>
</div>

