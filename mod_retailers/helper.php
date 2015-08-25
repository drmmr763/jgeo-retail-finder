<?php
/**
 * @Author  Chad Windnagle
 * @Project mod_retailers
 * Date: 8/24/15
 */

defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_restonicretailers/models', 'RestonicRetailersModel');

class modRetailersHelper
{
    protected $session;

    public function __construct($params)
    {
        $this->session = JFactory::getSession();
    }

    /*
     * Get the geo location from our session
     */
    public function getJGeoLocation()
    {
        $location = json_decode($this->session->get('jgeo_position'));

        return $location;
    }

    public function geoIsAvailable()
    {
        return $this->session->get('jgeo_position_status');
    }

    public static function retailersAjax()
    {
        $session = JFactory::getSession();

        $status = $session->get('jgeo_position_status', false);

        if ($status) {

            $results = array(
                'status' => $status,
                'location' => json_decode($session->get('jgeo_position')),
                'retailers' => self::getRetailers(),
            );

            return ($results);
        }

        return (array('status' => $status));
    }

    public static function getRetailers($limit = 2)
    {
        $model = JModelLegacy::getInstance('RetailerLocations', 'RestonicRetailersModel', array('ignore_request' => true));

        // Set application parameters in model
        $app       = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // limit
        //$limit = $params->get('limit', 2);

        $input = JFactory::getApplication()->input;

        $session = JFactory::getSession();

        $location = json_decode($session->get('jgeo_position'));

        $input->set('latitude', $location->latitude);
        $input->set('longitude', $location->longitude);
        $input->set('maximumDistance', 50);
        $input->set('maxResults', $limit);

        $items = $model->getItems();

        return $items;
    }
}