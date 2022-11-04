<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <https://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if ( ! class_exists( 'ReduxFramework' ) ) {
	return;
}

// Don't duplicate me!
if ( ! class_exists('ReduxFramework_social') ) {

    /**
     * Main ReduxFramework_social class
     *
     * @since       1.0.0
     */
    class ReduxFramework_social extends ReduxFramework {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {

            //parent::__construct( $parent->sections, $parent->args );
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            $this->enqueue();
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            echo '<div class="redux-accordion">';
            $x = 0;
			
            if (isset($this->value) && is_array($this->value)) {

                $socials = $this->value;

                foreach ($socials as $social) {
					
                    if ( empty( $social ) ) {
                        continue;
                    }
					
                    $defaults = array(
                        'title' => '',
                        'force_row' => 0,
                        'sort' => '',
                        'url' => '',
                        'select' => array(),
                    );
                    
					$social = wp_parse_args( $social, $defaults );
					
                    echo '<div class="redux-accordion-group">
							<fieldset class="redux-field" data-id="' . esc_attr( $this->field['id'] ) . '">
								<h3>
									<span class="redux-header">' . esc_html( $social['title'] ) . '</span>
								</h3>
								<div>
                    				<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-list">
                    					<li>
											<input type="text" id="' . esc_attr( $this->field['id'] . '-title_' . $x ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][title]" value="' . esc_attr( $social['title'] ) . '" placeholder="' . esc_attr__('Label', 'royal') . '" class="full-text social-title" />
										</li>
                    					<li>
											<input type="text" id="' . esc_attr( $this->field['id'] . '-url_' . $x ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][url]" value="' . esc_attr( $social['url'] ) . '" class="full-text" placeholder="' . esc_attr__('Link', 'royal') . '" />
										</li>
                    					<li>
											<input type="hidden" class="social-sort" name="' . $this->field['name'] . '[' . $x . '][sort]" id="' . esc_attr( $this->field['id'] . '-sort_' . $x ) . '" value="' . esc_attr( $social['sort'] ) . '" />
										</li>';
                    
					if ( isset( $this->field['options'] ) && !empty( $this->field['options'] ) ) {
                        $placeholder = (isset($this->field['placeholder']['options'])) ? $this->field['placeholder']['options'] : esc_html__( 'Select an Icon', 'royal' );
                        
						if ( isset( $this->field['select2'] ) ) { // if there are any let's pass them to js
                            $select2_params = json_encode( esc_attr( $this->field['select2'] ) );
                            $select2_params = htmlspecialchars( $select2_params , ENT_QUOTES);
                            echo '<input type="hidden" class="select2_params" value="'. esc_attr( $select2_params ) .'">';
                        }
						
                        echo '<select id="' . esc_attr( $this->field['id'] ) . '-select" data-placeholder="' . esc_attr( $placeholder ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][select]" class="font-awesome-icons redux-select-item ' . esc_attr( $this->field['class'] ) . '" rows="6">
								<option></option>';
                            
							foreach($this->field['options'] as $k => $v) {
                                if (is_array($this->value)) {
                                    $selected = $social['select'] == $k ?' selected="selected"':'';
                                } else {
                                    $selected = selected($this->value['select'], $k, false);
                                }
								
                                echo '<option value="' . esc_attr( $k ) . '"'. esc_attr( $selected ) . '>' . esc_html( $v ) . '</option>';
                            }
                        echo '</select>';
                    }
					
                    echo '					<li>
												<a href="javascript:void(0);" class="button deletion redux-remove">' . esc_html__('Delete Link', 'royal') . '</a>
											</li>
                    					</ul>
									</div>
								</fieldset>
							</div>';
					
                    $x++;
                }
            }

            if ($x == 0) {
                echo '<div class="redux-accordion-group hidden">
						<fieldset class="redux-field" data-id="' . esc_attr( $this->field['id'] ) . '">
							<h3>
								<span class="redux-header">' . esc_html__('New Social', 'royal') . '</span>
							</h3>
						  	<div>
								<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-list">';
                
				$placeholder = ( isset( $this->field['placeholder']['title'] ) ) ? $this->field['placeholder']['title'] : esc_html__( 'Label', 'royal' );
                
				echo '<li>
						<input type="text" id="' . esc_attr( $this->field['id'] . '-title_' . $x ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][title]" value="" placeholder="' . esc_attr( $placeholder ) . '" class="full-text social-title" />
					  </li>';
                
				$placeholder = ( isset( $this->field['placeholder']['url'] ) ) ? $this->field['placeholder']['url'] : esc_html__( 'Link', 'royal' );
                
				echo '<li>
						<input type="text" id="' . esc_attr( $this->field['id'] . '-url_' . $x ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][url]" value="" class="full-text" placeholder="' . esc_attr( $placeholder ) . '" />
					  </li>
               		  <li>
						<input type="hidden" class="social-sort" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][sort]" id="' . esc_attr( $this->field['id'] . '-sort_' . $x ) . '" value="' . esc_attr( $x ) . '" />
					  </li>';
                    
				if ( isset( $this->field['options'] ) && !empty( $this->field['options'] ) ) {
					$placeholder = ( isset( $this->field['placeholder']['select'] ) ) ? $this->field['placeholder']['select'] : esc_html__( 'Select an Icon', 'royal' );

					if ( isset( $this->field['select2'] ) ) { 
						// If there are any let's pass them to js
						$select2_params = json_encode( esc_attr( $this->field['select2'] ) );
						$select2_params = htmlspecialchars( $select2_params , ENT_QUOTES);
						echo '<input type="hidden" class="select2_params" value="'. esc_attr( $select2_params ) .'">';
					}

					echo '<select id="' . esc_attr( $this->field['id'] ) . '-select" data-placeholder="' . esc_attr( $placeholder ) . '" name="' . esc_attr( $this->field['name'] . '[' . $x ) . '][select]" class="font-awesome-icons redux-select-item ' . esc_attr( $this->field['class'] ) . '" rows="6" style="width:93%;">
							<option></option>';
						
						foreach ($this->field['options'] as $k => $v) {
							if (is_array($this->value)) {
								$selected = (is_array($this->value) && in_array($k, $this->value))?' selected="selected"':'';
							} else {
								$selected = selected($this->value, $k, false);
							}
							
							echo '<option value="'. esc_attr( $k ) . '"' . esc_attr( $selected ) . '>' . esc_html( $v ) . '</option>';
						}
					echo '</select>';
               	}

                echo '					<li>
											<a href="javascript:void(0);" class="button deletion redux-remove">' . esc_html__('Delete Link', 'royal') . '</a>
										</li>
                					</ul>
								</div>
							</fieldset>
						</div>';
            }
			
            echo '</div>
				  <a href="javascript:void(0);" class="button redux-add button-primary" rel-id="' . esc_attr( $this->field['id'] ) . '-ul" rel-name="' . esc_attr( $this->field['name'] ) . '[title][]">' . esc_html__('Add Link', 'royal') . '</a>
				  <br/>';
		}

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {
            wp_enqueue_script(
                'redux-field-js',
                get_template_directory_uri() . '/admin/social/social.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'wp-color-picker', 'select2-js'),
                time(),
                true
            );
			
            wp_enqueue_style(
                'redux-field-css',
                get_template_directory_uri() . '/admin/social/social.css',
                time(),
                true
            );
        }
    }
}
