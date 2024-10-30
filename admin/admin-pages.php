<?php
if( !class_exists('Swm_Admin_Pages') ){
	/**
	 * Register All Admin Pages from Here
	 */
	class SWM_Admin_Pages
	{

		private static $instance;

		public static function getInstance() {
	        if (!isset(self::$instance)) {
	            self::$instance = new Swm_Admin_Pages();
	        }
	        return self::$instance;
	    }
		
		function __construct() {
			add_action( 'admin_init', array($this, 'swm_register_setting') ); 
			add_action('admin_menu', array($this, 'swm_menu_page'));
			add_filter( 'custom_menu_order', array($this, 'swm_custom_menu_order'),50 );
		}

		public function swm_menu_page(){
			global $submenu;
			add_menu_page(
				__('Shopify to WC', 'wc-swm'),
				__('Shopify to WC', 'wc-swm'),
				'manage_options',
				'swm_shopify_to_wc',
				array($this, 'swm_menu_page_callback'),
				'dashicons-image-rotate-left',
				25
			);

			add_submenu_page(
				'swm_shopify_to_wc',
				'System Status',
				'System Status',
				'manage_options',
				'swm-system-status',
				array($this, 'page_callback_system_status')
			);

			$link_text = '<span class="swm-up-pro-link" style="font-weight: bold; color: #FCB214">Upgrade To Pro</span>';
			$submenu["swm_shopify_to_wc"][3] = array( $link_text, 'manage_options' , WB_SWM_UPGRADE_TO_PRO );
			
			return $submenu;
		}

		public function swm_menu_page_callback(){
			require_once('templates/main-admin-menu.php');
		}
		
		public function page_callback_system_status() {
			require_once('templates/system-status-sub-menu.php');
		}

		public function swm_register_setting() {
		    register_setting( 'swm_settings_options', 'wb_swm_store_url' );
		    register_setting( 'swm_settings_options', 'wb_swm_access_token');
			register_setting( 'swm_settings_options', 'wb_swm_api_key');
		    register_setting( 'swm_settings_options', 'wb_swm_api_pwd');
		    register_setting( 'swm_settings_options', 'wb_swm_product_status');
		    register_setting( 'swm_settings_options', 'wb_swm_download_images');
		    register_setting( 'swm_settings_options', 'wb_swm_product_categories');
		    register_setting( 'swm_settings_options', 'wb_swm_product_tags');
		    register_setting( 'swm_settings_options', 'wb_swm_request_timeout');
		    register_setting( 'swm_settings_options', 'wb_swm_result_per_request');

		    register_setting( 'swm_settings_options', 'wb_swm_download_cat_images');
		    register_setting( 'swm_settings_options', 'wb_swm_cats_per_request');
		    
		    register_setting( 'swm_settings_options', 'wb_swm_customer_per_request');
		    register_setting( 'swm_settings_options', 'wb_swm_order_per_request');
		}

		public function swm_custom_menu_order($menu_ord){
			global $submenu;
			//echo '<pre>'; print_r( $submenu['swm_shopify_to_wc'] ); echo '</pre>'; exit();

			$arr = array();
			$arr[] = $submenu['swm_shopify_to_wc'][0];
			$arr[] = $submenu['swm_shopify_to_wc'][1];
			$arr[] = $submenu['swm_shopify_to_wc'][4];
			$arr[] = $submenu['swm_shopify_to_wc'][3];
			$submenu['swm_shopify_to_wc'] = $arr;
			return $menu_ord;
		}

	}

}
