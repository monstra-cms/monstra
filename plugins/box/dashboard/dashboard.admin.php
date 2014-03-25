<?php

// Add Plugin Javascript
Stylesheet::add('public/assets/css/daterangepicker-bs3.css', 'backend', 11);
Javascript::add('public/assets/js/moment.min.js', 'backend', 11);
Javascript::add('public/assets/js/daterangepicker.js', 'backend', 12);
Javascript::add('plugins/box/dashboard/js/ganalytics.js', 'backend', 13);

/**
 * Dashboard admin class
 */
class DashboardAdmin extends Backend
{
    /**
     * Main Dashboard admin function
     */
    public static function main()
    {

        // set/update google analytics settings
		if (Request::post('ga_settings_update')) {
		
		    if (Security::check(Request::post('csrf'))) {
		        
		        // client id
		        $ga_client_id = trim(Request::post('ga_client_id'));
		        if (!empty($ga_client_id)) {
		            $opt_client_id = Option::get('ga_client_id');
		            if (empty($opt_client_id)) {
		                Option::add('ga_client_id', $ga_client_id);
		            } else {
		                Option::update('ga_client_id', $ga_client_id);
		            }
		        }
		        
		        // API key
		        $ga_api_key = trim(Request::post('ga_api_key'));
		        if (!empty($ga_api_key)) {
		            $opt_api_key = Option::get('ga_api_key');
		            if (empty($opt_api_key)) {
		                Option::add('ga_api_key', $ga_api_key);
		            } else {
		                Option::update('ga_api_key', $ga_api_key);
		            }
		        }
		        
		        // view id
		        $ga_view_id = trim(Request::post('ga_view_id'));
		        if (!empty($ga_view_id)) {
		            $opt_view_id = Option::get('ga_view_id');
		            if (empty($opt_view_id)) {
		                Option::add('ga_view_id', $ga_view_id);
		            } else {
		                Option::update('ga_view_id', $ga_view_id);
		            }
		        }
		        
		        // tracking id
		        $ga_tracking_id = trim(Request::post('ga_tracking_id'));
		        if (!empty($ga_tracking_id)) {
		            $opt_view_id = Option::get('ga_tracking_id');
		            if (empty($opt_view_id)) {
		                Option::add('ga_tracking_id', $ga_tracking_id);
		            } else {
		                Option::update('ga_tracking_id', $ga_tracking_id);
		            }
		        }
		    }
		        
		}
		
        // Display view
        View::factory('box/dashboard/views/backend/index')->display();
    }

}


/**
 * Dashboard
 */
class Dashboard 
{

    /**
     * Items
     *
     * @var array
     */
    public static $items = array();


    /**
     * 
     */
	public static function addNewItem($id, $title, $url, $priority = 1)
	{
        Dashboard::$items[] = array(
            'id'       => (string) $id,
            'title'    => (string) $title,
            'url'      => (string) $url,
            'priority' => (int) $priority,
        );
	}


	/**
	 * 
	 */
	public static function drawItems() 
	{
		// Sort items by priority
        $items = Arr::subvalSort(Dashboard::$items, 'priority');

		foreach ($items as $item) {
			echo '<li>';
			echo Html::anchor($item['title'], $item['url'], array('title' => $item['title']));
			echo '</li>';
		}
	}

}