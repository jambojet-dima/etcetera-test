<?php
/**
 * Ajax handler for coupon check
 *
 */
class Estate_Cpt_Widget_Ajax_Handler
{

	/**
	 * Action hook used by the AJAX class.
	 * @var string
	 */
	const ACTION = 'np_filter_estate';

	/**
	 * Action argument used by the nonce validating the AJAX request.
	 * @var string
	 */
	const NONCE = '_wpnonce_filter_estate';


	/**
	 * Register the AJAX handler class with all the appropriate WordPress hooks.
	 */
	public static function register() {
		$handler = new self();

		
		add_action('wp_ajax_'. self::ACTION, array($handler, 'handle') );
		add_action('wp_ajax_nopriv_'. self::ACTION, array($handler, 'handle') );
		
		//$handler->register_scripts();
		add_action('wp_enqueue_scripts', array($handler, 'register_scripts') );
		//add_action('wp_loaded', array($handler, 'register_script'));
		
		
		add_filter( 'posts_where', array($handler, 'replace_appartments_repeater_field') );
	}
	
	
	
	/**
    * Register our AJAX JavaScript.
    */
	public function register_scripts() {
		// don't run on ajax calls
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}		

		wp_register_script( 
			'axios', 
			plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/axios.min.js', 
			array(),
			null, 
			true 
		); //
		// register our main script but do not enqueue it yet
		$script_name = 'np-estate-widget-ajax';
		wp_register_script( 
			$script_name, 
			plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/estate-cpt-widget-public.js', 
			array('axios'),
			// array('jquery'),
			null, 
			true 
		); //
		wp_localize_script( $script_name, 'npEstateAjaxData', $this->get_ajax_data() );

		wp_enqueue_script( $script_name );
	}
	
	
	
	/**
     * Get the AJAX data that WordPress needs to output.
     *
     * @return array
     */
    private function get_ajax_data() {
        return array(
            'url' => admin_url('admin-ajax.php'), // WordPress AJAX
			'action' => self::ACTION,
			'nonce' => wp_create_nonce(self::NONCE),
        );
    }
	


	/**
	 * Handles the AJAX request for my plugin.
	 */
	public function handle(): void 
	{
		// only POST Method
		if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
			die;
		}
		
		// Make sure we are getting a valid AJAX request
		check_ajax_referer(self::NONCE);		

		// Show Estates
		echo $this->update_estates();
		
		die();
	}



	/**
	 * Update Products List
	 *
	 */
	public function update_estates() : string
	{	
	
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( $this->get_paged_number() ) {
			$paged = $this->get_paged_number();
		}
		
		$args = [
			'paged' => $paged,
			'post_type' => 'estate',
			'post_status' => 'publish',
			'posts_per_page' => 5,
			// 'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];
		
		
		/* Meta Query */
		$meta_query = array();
		$meta_query['relation'] = 'AND';
		
		
		// add Floors query
		if ( $this->get_floors_qty() ) {
			$meta_query[] = array(
				'key'		=> 'floors_qty',
				'value'		=> $this->get_floors_qty(),
				'compare'	=> '=',
			);
		}
		
		// add Building Type query
		if ( $this->get_building_type() ) {
			$meta_query[] = array(
				'key'		=> 'building_type',
				'value'		=> $this->get_building_type(),
				'compare'	=> '=',
			);
		}
		
		
		// add environmental friendliness query
		if ( $this->get_environmental_friendliness() ) {
			$meta_query[] = array(
				'key'		=> 'environmental_friendliness',
				'value'		=> $this->get_environmental_friendliness(),
				'compare'	=> '=',
			);
		}
		
		
		// appartments Meta
		
		// rooms
		if ( $this->get_show_appartments() && $this->get_rooms_qty() ) {
			$meta_query[] = array(
               'key' 		=> 'appartments_$_rooms_qty',
               'value' 		=> $this->get_rooms_qty(),
               'compare' 	=> '='
			);
		}
		
		
		// balcony
		if ( $this->get_show_appartments() && $this->get_balcony() ) {
			$meta_query[] = array(
               'key' 		=> 'appartments_$_balcony',
               'value' 		=> $this->get_balcony(),
               'compare' 	=> '='
			);
		}
		
		
		// bathroom
		if ( $this->get_show_appartments() && $this->get_bathroom() ) {
			$meta_query[] = array(
               'key' 		=> 'appartments_$_bathroom',
               'value' 		=> $this->get_bathroom(),
               'compare' 	=> '='
			);
		}
		
		// Set Meta query
		$args['meta_query'] = $meta_query;
		
		
		/* Tax query */
		$tax_query = array();
		if ( $this->get_taxonomy_term() ) {
			$tax_query[] = array(
				'taxonomy' => 'district',
                'field' => 'term_id',
                'terms' => array( $this->get_taxonomy_term() )
			);
		}		
		$args['tax_query'] = $tax_query;
		
		//print_r($args);
		$query = new WP_Query( $args );
		
		
		// Output content var
		$content = '';
		
		// If no posts
		if ( !$query->have_posts() ) {
			$content .= __('No buildings match your criteria', 'estate-cpt');
		}
		
		// loop throught the posts		
		while ( $query->have_posts() ) : $query->the_post();
			
			ob_start();
			/*
			if ( $this->get_show_appartments() ) {
				//echo 'app';
				include plugin_dir_path( dirname( __FILE__ ) ) . 'includes/partials/estate-cpt-loop-appartments.php';
			} else {
				include plugin_dir_path( dirname( __FILE__ ) ) . 'includes/partials/estate-cpt-loop-buildings.php';
			}
			*/
			include plugin_dir_path( dirname( __FILE__ ) ) . 'includes/partials/estate-cpt-loop-buildings.php';
			
			$content .= ob_get_contents();
			ob_end_clean();
			
		endwhile;
		
		$pagination = $this->post_pagination($paged, $query->max_num_pages);
		
		wp_reset_postdata();
		
		
		// Send json
		wp_send_json_success( array( 
			'posts' => $content, 
			'pagination' => $pagination,
		), 200 );
		
		// get the response
		//return $content;
	}
	
	
	
	
	public function post_pagination($paged = '', $max_page = '') {
		if (!$paged) {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
		}

		if (!$max_page) {
			global $wp_query;
			$max_page = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
		}

		$big  = 999999999; // need an unlikely integer

		$paginate_links = paginate_links(array(
			//'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'base' => site_url() . '%_%',
			'format'     => '?paged=%#%',
			'current'    => max(1, $paged),
			'total'      => $max_page,
			'mid_size'   => 1,
			'prev_text'  => __('« Prev'),
			'next_text'  => __('Next »'),
		));


		$html = '';
		if ($paginate_links) {
			$html = "<div class='estate-pagination'>" . $paginate_links . "</div>";
		}
		
		return $html;
	}
	
	
	
	
	/**
	 * Get Taxonomy query
	 */
	private function get_taxonomy_term(): ?int
	{
		$term_id = null;
		if ( isset($_POST['estate_district']) ) {
			$term_id = sanitize_text_field( $_POST['estate_district'] );
			$term_id = $term_id === 'all' ? null : (int)$term_id;
		}
		return $term_id;
	}



	
	/**
	 * Get Floors Qty
	 */
	private function get_floors_qty(): string
	{
		$floors_qty = '5';
		if ( isset($_POST['acf']['field_628f87c3f753e']) ) {
			$floors_qty = sanitize_text_field( $_POST['acf']['field_628f87c3f753e'] );
		}
		return $floors_qty;
	}


	/**
	 * Get Building type
	 */
	private function get_building_type(): string
	{
		$building_type = 'panel';
		if ( isset($_POST['acf']['field_628f88c3f753f']) ) {
			$building_type = sanitize_text_field( $_POST['acf']['field_628f88c3f753f'] );
		}
		return $building_type;
	}


	/**
	 * Get Post Type
	 */
	private function get_environmental_friendliness(): string
	{
		$environmental_friendliness = '4';
		if ( isset($_POST['acf']['field_628f8924f7540']) ) {
			$environmental_friendliness = sanitize_text_field( $_POST['acf']['field_628f8924f7540'] );
		}
		return $environmental_friendliness;
	}
	
	
	/**
	 * Get Paged Value
	 */	
	private function get_paged_number(): ?string
	{
		$paged = null;
		if ( isset($_POST['paged']) ) {
			$paged = sanitize_text_field( $_POST['paged'] );
		}
		return $paged;
	}
	
	
	
	/***** Appartments ****/
	
	private function get_show_appartments(): bool
	{
		$show = false;
		if ( isset($_POST['show_appartments']) ) {
			$show = true;
		}
		return $show;
	}
	
	
	// Rooms
	private function get_rooms_qty(): ?string
	{
		$rooms_qty = null;
		if ( isset($_POST['acf']['field_628f8a13f7544']) && $this->get_show_appartments() ) {
			$rooms_qty = sanitize_text_field( $_POST['acf']['field_628f8a13f7544'] );
		}
		return $rooms_qty;
	}
	
	
	// Balcony
	private function get_balcony(): string
	{
		$balcony = 'yes';
		if ( isset($_POST['acf']['field_628f8a81f7545']) && $this->get_show_appartments() ) {
			$balcony = sanitize_text_field( $_POST['acf']['field_628f8a81f7545'] );
		}
		return $balcony;
	}
	
	
	// Bathroom
	private function get_bathroom(): string
	{
		$bathroom = 'yes';
		if ( isset($_POST['acf']['field_628f8acbf7546']) && $this->get_show_appartments() ) {
			$bathroom = sanitize_text_field( $_POST['acf']['field_628f8acbf7546'] );
		}
		return $bathroom;
	}
	
	
	
	//
	public function replace_appartments_repeater_field($where) {
		$where = str_replace( "meta_key = 'appartments_$", "meta_key LIKE 'appartments_%", $where );
		return $where;
	}
}