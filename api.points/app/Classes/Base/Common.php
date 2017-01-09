<?php 
/**
* Utility class with common methods
*/
namespace App\Classes\Base;

class Common
{
	/**
	 * constructor
	 */
	public function __construct($option = array())
	{
		$this->set_option($option);
		$this->on_construct();
	}

	/**
	 * Excecuted on constructor
	 * @param array $option
	 */
	public function set_option($option = array()){
		$this->option = $option;		
	}

	/**
	 * Executed on construct 
	 */
	protected function on_construct(){}

	/**
	 * Combine user attributes with known attributes and fill in defaults when needed.
	 *
	 * The pairs should be considered to be all of the attributes which are
	 * supported by the caller and given as a list. The returned attributes will
	 * only contain the attributes in the $pairs list.
	 *
	 * If the $atts list has unsupported attributes, then they will be ignored and
	 * removed from the final returned list.
	 *
	 * @since 2.5.0
	 *
	 * @param array  $pairs     Entire list of supported attributes and their defaults.
	 * @param array  $atts      User defined attributes in shortcode tag.
	 * @param string $shortcode Optional. The name of the shortcode, provided for context to enable filtering
	 * @return array Combined and filtered attribute list.
	 */
	protected function shortcode_atts( $pairs, $atts, $shortcode = '' ) {
		$atts = (array)$atts;
		$out = array();
		foreach ($pairs as $name => $default) {
			if ( array_key_exists($name, $atts) )
				$out[$name] = $atts[$name];
			else
				$out[$name] = $default;
		}
		/**
		 * Filters a shortcode's default attributes.
		 *
		 * If the third parameter of the shortcode_atts() function is present then this filter is available.
		 * The third parameter, $shortcode, is the name of the shortcode.
		 *
		 * @since 3.6.0
		 * @since 4.4.0 Added the `$shortcode` parameter.
		 *
		 * @param array  $out       The output array of shortcode attributes.
		 * @param array  $pairs     The supported attributes and their defaults.
		 * @param array  $atts      The user defined shortcode attributes.
		 * @param string $shortcode The shortcode name.
		 */
		if ( $shortcode ) {
			$out = apply_filters( "shortcode_atts_{$shortcode}", $out, $pairs, $atts, $shortcode );
		}

		return $out;
	}
}