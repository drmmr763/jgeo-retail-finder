<?php
/**
 * @Author  Chad Windnagle
 * @Project mod_retailers
 * Date: 8/24/15
 */

defined('_JEXEC') or die;

class modRetailersHelper
{
    protected $session;

    public function __construct()
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

    public static function getRetailers()
    {
        return array();
    }
}