<?php
/**
 * Class for pre get posts CPT Estate
 *
 */
 
class NP_Estate_Ppre_Get_Posts
{
	
	/**
	 * Post type name
	 *
	 * @access   protected
	 * @var      string    $post_type    The post type name
	 */
	protected $post_type = 'estate';
	
	
	/**
	 * ACF order field
	 *
	 * @access   private
	 * @var      string    $order_field    ACF Field name | order posts by this field
	 */
	private $order_field = 'environmental_friendliness';
	
	
	/**
	 * Order value
	 *
	 * @access   private
	 * @var      string    $order_value    accepts (DESC|ASC)
	 */
	private $order_value = 'ASC';
	
	
	
	/**
	 * Init object of the class
	 *
	 * @access   private
	 * @var      string    $order_field    ACF Field name | order posts by this field | default value is 'environmental_friendliness'
	 */
	public function __construct(string $order_field = 'environmental_friendliness', string $order_value = 'ASC')
	{
		$this->order_field = $order_field;
		
		$order_values = ['DESC', 'ASC'];
		if ( in_array($order_value, $order_values) ) {
			$this->order_value = $order_value;
		} else {
			$this->order_value = 'ASC';
		}
		
	}
	
	
	/**
	 * Init the hook for pre get posts
	 *
	 */
	public function register()
	{
		
		add_action('pre_get_posts', array($this, 'estate_pre_get_posts'));
	}
	
	
	
	/**
	 * Set Pre Get Posts
	 * Skip if is_admin()
	 *
	 */
	public function estate_pre_get_posts( $query )
	{
		// do not modify queries in the admin
		if( is_admin() ) {			
			return $query;			
		}
		
		
		// only modify queries for 'event' post type
		if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == $this->post_type ) {
			
			$query->set('orderby', 'meta_value');	
			$query->set('meta_key', $this->order_field);	 
			$query->set('order', $this->order_value); 
			
		}
		
		
		// return
		return $query;
	}
	
}