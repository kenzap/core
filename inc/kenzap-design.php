<?php
/**
 * Kenzap Design System Class
 *
 * Provides systematic set of settings for your theme and plugins to look awesome
 *
 * @author      Kenzap
 * @package     Core
 * @version     1.0.0
 *
 * Based off the WooThemes installer.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kenzap_Design_System' ) ) {
	/**
	 * Kenzap_Design_System class
	 */
	class Kenzap_Design_System {

		protected $version = '1.0.0';

		/** @var string Current theme name, used as namespace in actions. */
		protected $theme_name = '';

		/**
		 * Relative plugin path
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $plugin_path = '';

		/**
		 * Relative plugin url for this plugin folder, used when enquing scripts
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $plugin_url = '';

		/**
		 * The slug name to refer to this menu
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $page_slug;

		/**
		 * The slug name for the parent menu
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $page_parent;

		/**
		 * Costom color palette array 
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $custom_colors;

		/**
		 * Holds the current instance of the theme manager
		 *
		 * @since 1.0.0
		 * @var Kenzap_Design_System
		 */
		private static $instance = null;

		/**
		 * @since 1.0.0
		 *
		 * @return Kenzap_Design_System
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * A dummy constructor to prevent this class from being loaded more than once.
		 *
		 * @see Kenzap_Design_System::instance()
		 *
		 * @since 1.0.0
		 * @access private
		 */
		public function __construct() {
			$this->init_globals();
			$this->init_actions();
		}

		/**
		 * Setup class globals.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function init_globals() {

			$theme = wp_get_theme();
  			$this->version = $theme['Version'];
			$this->theme_name = ucfirst( basename( get_template_directory() ) );
			$this->theme_slug = strtolower( $this->theme_name );
		}

		/**
		 * Setup the hooks, actions and filters.
		 *
		 * @uses add_action() To add actions.
		 * @uses add_filter() To add filters.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function init_actions() {

			add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ), 10 );
			add_action( 'admin_menu', array( $this, 'add_design_menu' ) );

			if(isset($_POST['action']))
				if($_POST['action']=="kenzap_design_ajax"){
					echo $this->form_submit(); die;
				}	
		}

		function load_custom_wp_admin_style($hook) {

			if($hook != 'appearance_page_design') {
					return;
			}
			//wp_enqueue_style( 'core', get_template_directory_uri() .'/css/core-style-'.$style.'.css', array(), $version, 'all' );
			wp_enqueue_style( 'kenzap_design', get_template_directory_uri(). '/css/design-system.css', array(), $this->version, 'all'  );
		}

		function kenzap_design_ajax(){

			$output = [];
			$output['success'] = $this->form_submit();
			echo json_encode($output);
			
			wp_reset_postdata();
			wp_die();
		}

		public function add_design_menu(){

			add_submenu_page( 'themes.php', esc_attr( 'Design System', $this->theme_slug ), esc_attr( 'Design System', $this->theme_slug ), 'administrator', 'design', array( $this, 'design_admin' ) );
		}

		public function design_admin(){

			$kp_font = get_theme_mod( 'kp_font', 0 );
			$font1 = get_theme_mod( 'font1', 0 );
			$font2 = get_theme_mod( 'font2', 0 );
			$font3 = get_theme_mod( 'font3', 0 );
			$kp_button = get_theme_mod( 'kp_button', 0 );
			$kp_palette = get_theme_mod( 'kp_palette', 'cyan|grey|indigo' );
			$custom_colors = get_theme_mod( 'custom_colors', '{}' );

			$ajaxurl = '';
			if( in_array('sitepress-multilingual-cms/sitepress.php', get_option('active_plugins')) ){
				$ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
			} else{
				$ajaxurl .= admin_url( 'admin-ajax.php');
			} ?>
			
			<script>
				var colors = <?php echo json_encode($this->core_colors()); ?>;
				var colors_custom = <?php echo ($custom_colors)?$custom_colors:'{}'; ?>;
				var kp_palette = '<?php echo $kp_palette; ?>';
				var ajax = '<?php echo esc_url($ajaxurl); ?>';
				var in_query = false;

				jQuery(function($) {
					
					kenzap_palette(kp_palette); 
					if(!isJsonString(colors_custom)){
						colors_custom = {};
						colors_custom["custom-1"] = colors['custom-1'];
						colors_custom["custom-2"] = colors['custom-2'];
						colors_custom["custom-3"] = colors['custom-3'];
					}
				});
				
				function pallette_listeners(){					
				
					jQuery(".color_cont_now,.color_cont").click(function(){

						if(jQuery(this).hasClass("color_cont_now")){

							var element = {};
							var cv = jQuery(this).find(".color_item_inp").val().toUpperCase();
							var ck = jQuery(this).find(".color_item_inp").data('key');
							var ckm = ck.substr(0,ck.length-4);
							var isColor = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(cv);

							// in case the custom color added overide defaults and update form
							if(ck.includes("custom") && isColor){

								colors_custom[ckm][ck] = cv;
								//console.log(colors_custom);
								jQuery("#custom_colors").val(JSON.stringify(colors_custom));
								jQuery(this).find("button").css("color",cv);
							}else{
								jQuery(this).find(".color_item_inp").val(colors[ckm][ck]);
								jQuery(this).find("button").css("color",colors[ckm][ck]);
								if(!isColor) alert("Wrong color!");
							}

							jQuery(".color_cont").css("transform", "scale(1)").css("position", "initial").removeClass("color_cont_now");
							jQuery(".color_cont_temp").remove();
							
						}else if(jQuery(this).hasClass("color_cont")){

							var temp = jQuery(this).clone();
							var el = this;
							
							jQuery(".color_cont").css("transform", "none").css("position", "initial");
							jQuery(".color_cont_temp").remove();
							jQuery(el).before( temp.addClass("color_cont_temp") );
							jQuery(el).css("transform", "scale(4)").css("position", "absolute").addClass("color_cont_now");

							var inp = jQuery(el).find(".color_item_inp");inp.focus();
							setTimeout(function(){var tmpStr = inp.val();inp.val('');inp.val(tmpStr);},10);
						}
					});
				}

				function kenzap_design_submit(el){

					if(in_query) return; in_query = true;
					jQuery(".wrap").fadeTo(400, 0.4);
					jQuery.post("", jQuery("#design_form").serialize(), function(data) {

						in_query = false;
						jQuery(".wrap").fadeTo(200, 1);
						alert("Changes applied");
					},'json');
					return false;
				}

				function kenzap_palette(val){

					var ca = val.split("|"); 
					var all_colors = Object.values(colors[ca[0]]);all_colors = all_colors.concat(Object.values(colors[ca[1]])).concat(Object.values(colors[ca[2]]));
					var all_colors_keys = Object.keys(colors[ca[0]]);all_colors_keys = all_colors_keys.concat(Object.keys(colors[ca[1]])).concat(Object.keys(colors[ca[2]]));
					var palette = '', ic = 0, ip = 1;

					for(var i=0;i<36;i++){
						palette +='\
						<div class="color_cont">\
							<button type="button" class="color_item" aria-pressed="false" style="color: '+all_colors[i]+'">\
							<input '+(all_colors_keys[i].includes("custom")?"contenteditable=\"true\"":"contenteditable=\"false\" readonly")+'  maxlength="7" data-key="'+(all_colors_keys[i])+'" class="color_item_inp" style="cursor:pointer;color:'+((ic<5)?all_colors[11*ip]:all_colors[12*ip-11])+';width:28px;font-size:6px;padding:0;margin:1px 0 0 -1.8px;display:flex;background:transparent;border:0;" value="'+all_colors[i]+'">\
							</button>\
						</div>';
						ic++;if(ic>11){ic = 0;ip++;}
					}
					jQuery( ".kp_palette" ).html(palette);
					pallette_listeners();
				}

				// function isHexaColor(sNum){
				// 	return (typeof sNum === "string") && sNum.length === 6 && ! isNaN( parseInt(sNum, 16) );
				// }

				function isJsonString(str) {
					try {
						JSON.parse(str);
					} catch (e) {
						return false;
					}
					return true;
				}

			</script>
			<div class="wrap">
				<h1>Design System</h1>
				
				<form id="design_form" method="post" action="themes.php?page=design" novalidate="novalidate">

					<input type="hidden" name="ajax" value="<?php echo esc_url($ajaxurl); ?>">
					<input type="hidden" name="action" value="kenzap_design_ajax">
					<input type="hidden" id="_wpnonce" name="_wpnonce" value="6f0e21057d">
					<input type="hidden" name="_wp_http_referer" value="themes.php?page=design">
					<input type="hidden" id="custom_colors" name="custom_colors" value="">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row"><label for="blogname">Content Width</label></th>
								<td>
									<input name="kp_width" type="number" id="designwidth" aria-describedby="tagline-description" value="<?php echo esc_attr(get_theme_mod( 'kp_width', 1200 )); ?>" class="regular-text">
									<p class="description" id="tagline-description">Default container width for all pages. Setting is ignored with align full/wide layout types.</p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="designpadding">Left Right Paddings</label></th>
								<td>
									<input name="kp_padding" type="number" id="designpadding" aria-describedby="tagline-description" value="<?php echo esc_attr(get_theme_mod( 'kp_padding', 15 )); ?>" class="regular-text">
									<p class="description" id="tagline-description">Left & right container paddings. Setting is ignored with align full/wide layout types</p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="siteurl">Font Pair</label></th>
								<td>
									<?php 
									echo '<select name="kp_font" class="kp-input" >';
									foreach ( $this->font_pairs() as $font ) : ?>
										<option <?php if($kp_font==$font) echo "selected"; ?> value="<?php echo $font; ?>"><?php echo $font; ?></option> 
									<?php endforeach; ?>
									</select>

									<p class="desc">Choose font pair. Not sure which one? <a href="https://fontpair.co/" target="_blank">Preview here</a>. For custom font settings go to <i>Customizer &gt; Fonts</i> section.</p>
								</td>
							</tr>

							<tr>
								<th scope="row">Color Palette</th>
								<td> 
									<select name="kp_palette" class="kp-input" onchange="kenzap_palette(this.value);" ; >
										<?php foreach ( $this->color_palette() as $color ) : ?>
											<option <?php if($kp_palette==$color) echo "selected"; ?> value="<?php echo $color; ?>"><?php echo $this->color_palette_parser($color); ?></option> 
										<?php endforeach; ?>
									</select>
									<div>
										<br>
										<div class="kp_palette"> </div>
									</div>
									<p class="description">Choose among different color palettes. Note. After update previous colors will be replaced through all database.</p>
								</td>
							</tr>

							<tr style="display:none;">
								<th scope="row">Membership</th>
								<td> 
									<fieldset>
										<legend class="screen-reader-text"><span>Membership</span></legend>
										<label for="design_xxx">
											<input name="design_xxx" type="checkbox" id="design_xxx" value="1" checked="checked">
											Anyone can register
										</label>
									</fieldset>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="design_button">Button type</label></th>
								<td>
									<select name="kp_button" id="design_button">
										<option <?php echo ($kp_button=='square')?"selected":"";?> value="square">Square</option>
										<option <?php echo ($kp_button=='round1')?"selected":"";?> value="round1">Slightly round corners</option>
										<option <?php echo ($kp_button=='round2')?"selected":"";?> value="round2">Round corners</option>
									</select>

									<p class="description">Choose button style. Compatible with all Kenzap blocks.</p>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="kp_button_e">Button effect</label></th>
								<td>
									<select name="kp_button_e" id="kp_button_e">
										<option <?php echo ($kp_button=='')?"selected":"";?> value="">No effect</option>
										<!-- <option <?php echo ($kp_button=='gradient1')?"selected":"";?> value="gradient1">Vertical gradient</option>
										<option <?php echo ($kp_button=='gradient2')?"selected":"";?> value="gradient2">Horizontal gradient</option> -->
										<option <?php echo ($kp_button=='border1')?"selected":"";?> value="border1">Dark border bottom</option>
										<option <?php echo ($kp_button=='border2')?"selected":"";?> value="border2">Light border top</option>
									</select>

									<p class="description">Choose button effect. Compatible with all Kenzap blocks.</p>
								</td>
							</tr>
						</tbody>
					</table>

					<p class="submit"><input type="button" name="submit" id="design_submit" class="button button-primary" value="Save Changes" onclick="kenzap_design_submit(this);"></p>
				</form>
			</div>
				
			<?php

			exit;
		}

		public function get_palette($kp_palette){


		}

		public function form_submit(){

			// design form submitted
			if(isset($_POST['kp_width'])){
				set_theme_mod( 'kp_width', $_POST['kp_width'] );
			}

			if(isset($_POST['kp_padding'])){
				set_theme_mod( 'kp_padding', $_POST['kp_padding'] );
			}

			if(isset($_POST['kp_font'])){
				set_theme_mod( 'kp_font', $_POST['kp_font'] );
			}

			if(isset($_POST['custom_colors'])){

				$str = preg_replace('/\\\"/',"\"", $_POST['custom_colors']);
				set_theme_mod( 'custom_colors', $str );
			}

			if(isset($_POST['kp_palette'])){

				// only update if color changed
				$kp_palette_prev = get_theme_mod( 'kp_palette' );
				global $wpdb;
				if( $kp_palette_prev != $_POST['kp_palette']){

					$colors_all = $this->core_colors();
					$kp_palette_prev_arr = explode("|", $kp_palette_prev);
					$kp_palette_next_arr = explode("|", $_POST['kp_palette']);
					
					$colors_old = array_merge($colors_all[$kp_palette_prev_arr[0]], $colors_all[$kp_palette_prev_arr[1]]); 
					$colors_old = array_merge($colors_old, $colors_all[$kp_palette_prev_arr[2]]); 

					$colors_new = array_merge($colors_all[$kp_palette_next_arr[0]], $colors_all[$kp_palette_next_arr[1]]); 
					$colors_new = array_merge($colors_new, $colors_all[$kp_palette_next_arr[2]]); 
					$colors_new = array_values($colors_new);

					$colors_old_hex = [];
					$colors_new_hex = [];

					$i=0;

					foreach ( $colors_old as $key => $color ){ array_push($colors_old_hex,$this->hex2rgbaDB($color)); }	
					foreach ( $colors_new as $key => $color ){ array_push($colors_new_hex,$this->hex2rgbaDB($color)); if($i==8){ set_theme_mod( 'kp_color', $color ); } if($i==19){ set_theme_mod( 'kp_color_text2', $color ); } if($i==23){ set_theme_mod( 'kp_color_text1', $color ); } $i++; }

					$colors_old = array_merge($colors_old, $colors_old_hex); 
					$colors_new = array_merge($colors_new, $colors_new_hex); 

					//print_r($colors_all);
					//print_r($colors_new);

					$arg = array(
						'post_type'      => 'page',
						'posts_per_page' => 1000,
					);
					$wp_query = new WP_Query( $arg );
					?>

					<?php if ( $wp_query->have_posts() ) : ?>
						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
							<?php

							//$post = apply_filters( 'the_content', get_the_content() );
							$post = get_the_content();
							$i = 0;
							foreach ( $colors_old as $key => $color_old ){

								$post = str_ireplace($color_old,$colors_new[$i],$post);
								//echo $color_old."|".$colors_new[$i]."-";
								$i++;
							}

							// $my_post = array();
							// $my_post['ID'] = get_the_ID();
							// $my_post['post_content'] = $post;
							// wp_update_post( $my_post );

							$id = get_the_ID();		
							$table_name = $wpdb->prefix . "posts";
							$wpdb->update( $table_name, array( 'post_content' => $post), array('ID'=>$id) ); ?>

						<?php endwhile; ?>
					<?php endif; 

					wp_reset_postdata();
					
					set_theme_mod( 'kp_palette', $_POST['kp_palette'] );
				}
			}

			if(isset($_POST['kp_button'])){
				set_theme_mod( 'kp_button', $_POST['kp_button'] );
			}

			if(isset($_POST['kp_button_e'])){
				set_theme_mod( 'kp_button_e', $_POST['kp_button_e'] );
			}

			delete_transient('core_buffer');

			echo true;
		}

		public function font_pairs(){

			//return 
			$r = array('- Custom Fonts','Lora & Merriweather','Proza Libre & Open Sans','Libre Baskerville & Source Sans Pro','Rubik & Karla','Asap & Asap','Work Sans & Work Sans','Domine & Roboto','Fira Sans & Merriweather','Karla & Karla','Nunito & Nunito','Space Mono & Space Mono','Poppins & PT Serif','Muli & Muli','BioRhyme & Space Mono','Saira & Saira','IBM Plex Sans & IBM Plex Serif','Archivo Black & Roboto','Halant & Nunito Sans','Rubik & Rubik','Spectral & Karla','Maven Pro & Maven Pro','Lora & Roboto','Alegreya & Alegreya','Montserrat & Source Sans Pro','Raleway & Raleway','Chivo & Overpass','Domine & Open Sans','Dosis & Dosis','Work Sans & Bitter','Inconsolata & Inconsolata','Alegreya Sans & Alegreya','Archivo Narrow & Merriweather','Cabin & Old Standard TT','Fjalla One & Average','Istok Web & Lora','Lato & Merriweather','Libre Franklin & Libre Baskerville','Merriweather Sans & Merriweather','Montserrat & Cardo','Montserrat & Crimson Text','Montserrat & Domine','Montserrat & Neuton','Nunito & Alegreya','Nunito & Lora','Open Sans & Gentium Book Basic','Open Sans & Libre Baskerville','Open Sans & Lora','Oswald & Merriweather','Oswald & Old Standard TT','Oswald & Quattrocento','PT Sans & PT Serif','Quicksand & EB Garamond','Raleway & Merriweather','Source Sans Pro & Source Serif Pro','Ubuntu & Lora','Work Sans & Taviraj','BioRhyme & Cabin','Cormorant Garamond & Proza Libre','Alegreya & Open Sans','Alegreya & Source Sans Pro','Bitter & Raleway','Bree Serif & Open Sans','Cantata One & Imprima','Cardo & Josefin Sans','Crete Round & AbeeZee','Josefin Slab & Josefin Sans','Kreon & Ubuntu','Libre Baskerville & Montserrat','Libre Baskerville & Open Sans','Lora & Source Sans Pro','Lustria & Lato','Merriweather & Open Sans','Merriweather & Source Sans Pro','Old Standard TT & Questrial','Ovo & Muli','Playfair Display & Open Sans','PT Serif & Open Sans','Quattrocento & Quattrocento Sans','Roboto Slab & Open Sans','Roboto Slab & Roboto','Rokkitt & Roboto','Rokkitt & Ubuntu','Rufina & Sintony','Trirong & Rubik','Spectral & Source Sans Pro','Vollkorn & Exo','Abel & Ubuntu','Amaranth & Titillium Web','Didact Gothic & Arimo','Dosis & Open Sans','Droid Sans & Cabin','Fira Sans & Montserrat','Fjalla One & Cantarell','Francois One & Didact Gothic','Francois One & Lato','Francois One & Open Sans','Hind & Open Sans','Karla & Montserrat','Karla & Lato','Montserrat & Hind','Montserrat & Istok Web','Nunito Sans & Nunito','Nunito & Open Sans','Open Sans & Nunito','Open Sans & Oswald','Oswald & Droid Sans','Oswald & Open Sans','Oxygen & Source Sans Pro','Philosopher & Muli','Poppins & Open Sans','PT Sans & Cabin','PT Sans & Didact Gothic','Raleway & Cabin','Raleway & Roboto','Roboto & Nunito','Signika & Open Sans','Ubuntu & Cabin','Ubuntu & Didact Gothic','Ubuntu & Hind','Ubuntu & Source Sans Pro','Walter Turncoat & Kreon','Yeseva One & Crimson Text','Abril Fatface & Droid Sans','Abril Fatface & Josefin Sans','Abril Fatface & Lato','Amatic SC & Andika','Amatic SC & Josefin Sans','Bevan & Pontano Sans','Flamenco & Asap','Lobster & Arimo','Lobster & Cabin','Medula One & Lato','Pacifico & Arimo','Patua One & Oswald','Rancho & Gudea','Shadows & Roboto','Squada One & Allerta','Stint Ultra & Pontano Sans','Yeseva One & Josefin Sans','Alfaslab One & Gentium Book','Clicker Script & EB Garamond','Dancing Script & Ledger','Dancing Script & EB Garamond','Nixie One & Ledger','Patua One & Lora','Nixie One & Libre Baskerville','Sacramento & Alice','Sansita One & Kameron','Unica One & Vollkorn','Bree Serif & Lora','Eczar & Gentium Basic','Playfair Display & Alice','Playfair Display & Fauna One','Quando & Judson','Quattrocento & Fanwood Text','Poppins & Anonymous Pro','Karla & Inconsolata','Inconsolata & Montserrat','Space Mono & Work Sans','Space Mono & Roboto');
			sort($r);

			return $r;
		}

		public function color_palette_parser($color){

			$color = str_replace( '-', ' ', $color );
			$arr = explode("|", $color);
			return ucfirst($arr[0])." - ".ucfirst($arr[1])." - ".ucfirst($arr[2]);
		}

		function color_palette() {
	
			// Add style section
			return array( 
				//1
				"cyan|grey|indigo",
				"cyan|grey|pink",
				"cyan|grey|red",
				"cyan|grey|yellow",
				//2
				"blue|grey|cyan",
				"blue|grey|red",
				//3
				"purple|blue-grey|light-blue-vivid",
				"yellow|blue-grey|red-vivid",
				"yellow|blue-grey|yellow-vivid",
				"teal|blue-grey|light-blue-vivid",
				"teal|blue-grey|red-vivid",
				"teal|blue-grey|yellow-vivid",
				//4
				"teal|blue-grey|blue",
				"teal|blue-grey|purple",
				"teal|blue-grey|red", 
				"teal|blue-grey|yellow", 
				//5
				// "teal|blue-grey|blue",
				// "teal|blue-grey|purple",
				// "teal|blue-grey|red", 
				// "teal|blue-grey|yellow", 
				//6
				"red|warm-grey|cyan",
				"red|warm-grey|lime-green",
				"yellow-vivid|warm-grey|cyan", 
				"yellow-vivid|warm-grey|lime-green", 
				//6
				"cyan|warm-grey|blue",
				"cyan|warm-grey|red",
				"cyan|warm-grey|yellow", 
				"cyan|warm-grey|teal", 
				//7
				"cyan|warm-grey|blue",
				"cyan|warm-grey|red",
				"cyan|warm-grey|yellow", 
				"cyan|warm-grey|teal", 
				//8
				"blue-vivid|cool-grey|cyan-vivid",
				"blue-vivid|cool-grey|orange-vivid",
				"blue-vivid|cool-grey|red-vivid", 
				"blue-vivid|cool-grey|yellow-vivid", 
				//9
				"light-blue-vivid|cool-grey|pink-vivid",
				"light-blue-vivid|cool-grey|red-vivid",
				"light-blue-vivid|cool-grey|yellow-vivid", 
				"light-blue-vivid|cool-grey|teal", 
				//10
				"indigo|cool-grey|light-blue-vivid",
				"indigo|cool-grey|red-vivid",
				"indigo|cool-grey|yellow-vivid", 
				"indigo|cool-grey|teal", 
				//11
				"pink-vivid|cool-grey|purple-vivid",
				"pink-vivid|cool-grey|cyan-vivid",
				"pink-vivid|cool-grey|red-vivid", 
				"pink-vivid|cool-grey|yellow-vivid", 
				//12
				"green|grey|purple",
				"green|grey|red",
				"green|grey|yellow",
				//13
				"yellow-vivid|grey|red-vivid",
				"yellow-vivid|grey|teal",
				"light-blue-vivid|grey|red-vivid",
				"light-blue-vivid|grey|teal",
				//14
				"orange|grey|light-blue",
				"orange|grey|red",
				"orange|grey|yellow",
				"lime-green|grey|light-blue",
				"lime-green|grey|red",
				"lime-green|grey|yellow",
				//15
				"blue|blue-grey|teal-vivid",
				"blue|blue-grey|red",
				"blue|blue-grey|yellow",
				//16
				"purple|blue-grey|teal-vivid",
				"purple|blue-grey|yellow-vivid",
				"red-vivid|blue-grey|teal-vivid",
				"red-vivid|blue-grey|yellow-vivid",
				//17
				"magenta|blue-grey|yellow-vivid",
				"magenta|blue-grey|red-vivid",
				"magenta|blue-grey|green-vivid",
				"orange-vivid|blue-grey|yellow-vivid",
				"orange-vivid|blue-grey|red-vivid",
				"orange-vivid|blue-grey|green-vivid",
				//18
				"purple|warm-grey|cyan",
				"purple|warm-grey|red-vivid",
				"purple|warm-grey|yellow",
				"purple|warm-grey|green-vivid",
				//19
				//"indigo|cool-grey|magenta-vivid",
				"indigo|cool-grey|red-vivid",
				"indigo|cool-grey|yellow-vivid",
				"indigo|cool-grey|green-vivid",
				"orange-vivid|cool-grey|cyan",
				"orange-vivid|cool-grey|red-vivid",
				"orange-vivid|cool-grey|yellow-vivid",
				"orange-vivid|cool-grey|green-vivid",

				//custom
				"custom-1|custom-2|custom-3",
			);
		}
		
		public static function core_colors(){
		
			// dimensional associative array 
			$static_colors = array(
				"cyan" => array( 
					"cyan-025" => "#FAFFFF",
					"cyan-050" => "#E0FCFF",
					"cyan-100" => "#BEF8FD",
					"cyan-200" => "#87EAF2",
					"cyan-300" => "#54D1DB",
					"cyan-400" => "#38BEC9",
					"cyan-500" => "#2CB1BC",
					"cyan-600" => "#14919B",
					"cyan-700" => "#0E7C86",
					"cyan-800" => "#0A6C74",
					"cyan-900" => "#044E54",
					"cyan-950" => "#002E33"
				), 
				"grey" => array( 
					"grey-025" => "#FBFCFE",
					"grey-050" => "#F0F4F8",
					"grey-100" => "#D9E2EC",
					"grey-200" => "#BCCCDC",
					"grey-300" => "#9FB3C8",
					"grey-400" => "#829AB1",
					"grey-500" => "#627D98",
					"grey-600" => "#486581",
					"grey-700" => "#334E68",
					"grey-800" => "#243B53",
					"grey-900" => "#102A43",
					"grey-950" => "#152636",
				), 
				"indigo" => array( 
					"indigo-025" => "#FAFBFF",
					"indigo-050" => "#E0E8F9",
					"indigo-100" => "#BED0F7",
					"indigo-200" => "#98AEEB",
					"indigo-300" => "#7B93DB",
					"indigo-400" => "#647ACB",
					"indigo-500" => "#4C63B6",
					"indigo-600" => "#4055A8",
					"indigo-700" => "#35469C",
					"indigo-800" => "#2D3A8C",
					"indigo-900" => "#19216C",
					"indigo-950" => "#00033E",
				), 
				"pink" => array( 
					"pink-025" => "#FFFAFC",
					"pink-050" => "#FFE0F0",
					"pink-100" => "#FAB8D9",
					"pink-200" => "#F191C1",
					"pink-300" => "#E668A7",
					"pink-400" => "#DA4A91",
					"pink-500" => "#C42D78",
					"pink-600" => "#AD2167",
					"pink-700" => "#9B1B5A",
					"pink-800" => "#781244",
					"pink-900" => "#5C0B33",
					"pink-950" => "#4D0024",
				),
				"red" => array( 
					"red-025" => "#FFFAFA",
					"red-050" => "#FFEEEE",
					"red-100" => "#FACDCD",
					"red-200" => "#F29B9B",
					"red-300" => "#E66A6A",
					"red-400" => "#D64545",
					"red-500" => "#BA2525",
					"red-600" => "#A61B1B",
					"red-700" => "#911111",
					"red-800" => "#780A0A",
					"red-900" => "#610404",
					"red-950" => "#4D0000",
				),
				"green" => array( 
					"green-025" => "#FAFEFB",
					"green-050" => "#E3F9E5",
					"green-100" => "#C1EAC5",
					"green-200" => "#A3D9A5",
					"green-300" => "#7BC47F",
					"green-400" => "#57AE5B",
					"green-500" => "#3F9142",
					"green-600" => "#2F8132",
					"green-700" => "#207227",
					"green-800" => "#0E5814",
					"green-900" => "#05400A",
					"green-950" => "#002700",
				),
				"green-vivid" => array( 
					"green-vivid-025" => "#FAFEFA",
					"green-vivid-050" => "#E3F9E5",
					"green-vivid-100" => "#C1F2C7",
					"green-vivid-200" => "#91E697",
					"green-vivid-300" => "#51CA58",
					"green-vivid-400" => "#31B237",
					"green-vivid-500" => "#18981D",
					"green-vivid-600" => "#0F8613",
					"green-vivid-700" => "#0E7817",
					"green-vivid-800" => "#07600E",
					"green-vivid-900" => "#014807",
					"green-vivid-950" => "#002C00",
				),
				"yellow" => array( 
					"yellow-025" => "#FFFEFA",
					"yellow-050" => "#FFFAEB",
					"yellow-100" => "#FCEFC7",
					"yellow-200" => "#F8E3A3",
					"yellow-300" => "#F9DA8B",
					"yellow-400" => "#F7D070",
					"yellow-500" => "#E9B949",
					"yellow-600" => "#C99A2E",
					"yellow-700" => "#A27C1A",
					"yellow-800" => "#7C5E10",
					"yellow-900" => "#513C06",
					"yellow-950" => "#312000",
				),
				"blue" => array( 
					"blue-025" => "#FAFDFF",
					"blue-050" => "#DCEEFB",
					"blue-100" => "#B6E0FE",
					"blue-200" => "#84C5F4",
					"blue-300" => "#62B0E8",
					"blue-400" => "#4098D7",
					"blue-500" => "#2680C2",
					"blue-600" => "#186FAF",
					"blue-700" => "#0F609B",
					"blue-800" => "#0A558C",
					"blue-900" => "#003E6B",
					"blue-950" => "#002A4D",
				),
				"yellow-vivid" => array( 
					"yellow-vivid-025" => "#FFFEFA",
					"yellow-vivid-050" => "#FFFBEA",
					"yellow-vivid-100" => "#FFF3C4",
					"yellow-vivid-200" => "#FCE588",
					"yellow-vivid-300" => "#FADB5F",
					"yellow-vivid-400" => "#F7C948",
					"yellow-vivid-500" => "#F0B429",
					"yellow-vivid-600" => "#DE911D",
					"yellow-vivid-700" => "#CB6E17",
					"yellow-vivid-800" => "#B44D12",
					"yellow-vivid-900" => "#8D2B0B",
					"yellow-vivid-950" => "#3E0300",
				),
				"blue-grey" => array( 
					"blue-grey-025" => "#FBFCFE",
					"blue-grey-050" => "#F0F4F8",
					"blue-grey-100" => "#D9E2EC",
					"blue-grey-200" => "#BCCCDC",
					"blue-grey-300" => "#9FB3C8",
					"blue-grey-400" => "#829AB1",
					"blue-grey-500" => "#627D98",
					"blue-grey-600" => "#486581",
					"blue-grey-700" => "#334E68",
					"blue-grey-800" => "#243B53",
					"blue-grey-900" => "#102A43",
					"blue-grey-950" => "#152636",  
				),
				"purple" => array( 
					"purple-025" => "#FAFAFF",
					"purple-050" => "#E6E6FF",
					"purple-100" => "#C4C6FF",
					"purple-200" => "#A2A5FC",
					"purple-300" => "#8888FC",
					"purple-400" => "#7069FA",
					"purple-500" => "#5D55FA",
					"purple-600" => "#4D3DF7",
					"purple-700" => "#3525E6",
					"purple-800" => "#1D0EBE",
					"purple-900" => "#0C008C", 
					"purple-950" => "#06014D", 
				),
				"teal" => array( 
					"teal-025" => "#FAFFFD",
					"teal-050" => "#EFFCF6",
					"teal-100" => "#C6F7E2",
					"teal-200" => "#8EEDC7",
					"teal-300" => "#65D6AD",
					"teal-400" => "#3EBD93",
					"teal-500" => "#27AB83",
					"teal-600" => "#199473",
					"teal-700" => "#147D64",
					"teal-800" => "#0C6B58",
					"teal-900" => "#014D40",
					"teal-950" => "#002F25",
				),
				"teal-vivid" => array( 
					"teal-vivid-025" => "#FAFFFE",
					"teal-vivid-050" => "#F0FCF9",
					"teal-vivid-100" => "#C6F7E9",
					"teal-vivid-200" => "#8EEDD1",
					"teal-vivid-300" => "#5FE3C0",
					"teal-vivid-400" => "#2DCCA7",
					"teal-vivid-500" => "#17B897",
					"teal-vivid-600" => "#079A82",
					"teal-vivid-700" => "#048271",
					"teal-vivid-800" => "#016457",
					"teal-vivid-900" => "#004440",
					"teal-vivid-950" => "#001D15",
				),
				"light-blue" => array( 
					"light-blue-025" => "#FAFDFF",
					"light-blue-050" => "#EBF8FF",
					"light-blue-100" => "#D1EEFC",
					"light-blue-200" => "#A7D8F0",
					"light-blue-300" => "#7CC1E4",
					"light-blue-400" => "#55AAD4",
					"light-blue-500" => "#3994C1",
					"light-blue-600" => "#2D83AE",
					"light-blue-700" => "#1D6F98",
					"light-blue-800" => "#166086",
					"light-blue-900" => "#0B4F71", 
					"light-blue-950" => "#002944", 
				),
				"light-blue-vivid" => array( 
					"light-blue-vivid-025" => "#FAFEFF",
					"light-blue-vivid-050" => "#E3F8FF",
					"light-blue-vivid-100" => "#B3ECFF",
					"light-blue-vivid-200" => "#81DEFD",
					"light-blue-vivid-300" => "#5ED0FA",
					"light-blue-vivid-400" => "#40C3F7",
					"light-blue-vivid-500" => "#2BB0ED",
					"light-blue-vivid-600" => "#1992D4",
					"light-blue-vivid-700" => "#127FBF",
					"light-blue-vivid-800" => "#0B69A3",
					"light-blue-vivid-900" => "#035388", 
					"light-blue-vivid-950" => "#002953", 
				),
				"red-vivid" => array( 
					"red-vivid-025" => "#FFFAFA",
					"red-vivid-050" => "#FFE3E3",
					"red-vivid-100" => "#FFBDBD",
					"red-vivid-200" => "#FF9B9B",
					"red-vivid-300" => "#F86A6A",
					"red-vivid-400" => "#EF4E4E",
					"red-vivid-500" => "#E12D39",
					"red-vivid-600" => "#CF1124",
					"red-vivid-700" => "#AB091E",
					"red-vivid-800" => "#8A041A",
					"red-vivid-900" => "#610316",  
					"red-vivid-950" => "#2B0000",  
				),
				"pink-vivid" => array( 
					"pink-vivid-025" => "#FFFAFD",
					"pink-vivid-050" => "#FFE3EC",
					"pink-vivid-100" => "#FFB8D2",
					"pink-vivid-200" => "#FF8CBA",
					"pink-vivid-300" => "#F364A2",
					"pink-vivid-400" => "#E8368F",
					"pink-vivid-500" => "#DA127D",
					"pink-vivid-600" => "#BC0A6F",
					"pink-vivid-700" => "#A30664",
					"pink-vivid-800" => "#870557",
					"pink-vivid-900" => "#620042",  
					"pink-vivid-950" => "#3C0023",  
				),
				"warm-grey" => array( 
					"warm-grey-025" => "#FDFDFC",
					"warm-grey-050" => "#FAF9F7",
					"warm-grey-100" => "#E8E6E1",
					"warm-grey-200" => "#D3CEC4",
					"warm-grey-300" => "#B8B2A7",
					"warm-grey-400" => "#A39E93",
					"warm-grey-500" => "#857F72",
					"warm-grey-600" => "#625D52",
					"warm-grey-700" => "#504A40",
					"warm-grey-800" => "#423D33",
					"warm-grey-900" => "#27241D", 
					"warm-grey-950" => "#2B271F", 
				),
				"lime-green" => array( 
					"lime-green-025" => "#FDFFFA",
					"lime-green-050" => "#F2FDE0",
					"lime-green-100" => "#E2F7C2",
					"lime-green-200" => "#C7EA8F",
					"lime-green-300" => "#ABDB5E",
					"lime-green-400" => "#94C843",
					"lime-green-500" => "#7BB026",
					"lime-green-600" => "#63921A",
					"lime-green-700" => "#507712",
					"lime-green-800" => "#42600C",
					"lime-green-900" => "#2B4005", 
					"lime-green-950" => "#162700", 
				),
				"blue-vivid" => array( 
					"blue-vivid-025" => "#FAFCFF",
					"blue-vivid-050" => "#E6F6FF",
					"blue-vivid-100" => "#BAE3FF",
					"blue-vivid-200" => "#7CC4FA",
					"blue-vivid-300" => "#47A3F3",
					"blue-vivid-400" => "#2186EB",
					"blue-vivid-500" => "#0967D2",
					"blue-vivid-600" => "#0552B5",
					"blue-vivid-700" => "#03449E",
					"blue-vivid-800" => "#01337D",
					"blue-vivid-900" => "#002159", 
					"blue-vivid-950" => "#000B37", 
				),
				"cool-grey" => array( 
					"cool-grey-025" => "#FCFCFD",
					"cool-grey-050" => "#F5F7FA",
					"cool-grey-100" => "#E4E7EB",
					"cool-grey-200" => "#CBD2D9",
					"cool-grey-300" => "#9AA5B1",
					"cool-grey-400" => "#7B8794",
					"cool-grey-500" => "#616E7C",
					"cool-grey-600" => "#52606D",
					"cool-grey-700" => "#3E4C59",
					"cool-grey-800" => "#323F4B",
					"cool-grey-900" => "#1F2933",  		  
					"cool-grey-950" => "#0F171F",  		  
				),
				"cyan-vivid" => array( 
					"cyan-vivid-025" => "#FAFFFF",
					"cyan-vivid-050" => "#E1FCF8",
					"cyan-vivid-100" => "#C1FEF6",
					"cyan-vivid-200" => "#92FDF2",
					"cyan-vivid-300" => "#62F4EB",
					"cyan-vivid-400" => "#3AE7E1",
					"cyan-vivid-500" => "#1CD4D4",
					"cyan-vivid-600" => "#0FB5BA",
					"cyan-vivid-700" => "#099AA4",
					"cyan-vivid-800" => "#07818F",
					"cyan-vivid-900" => "#05606E", 		  
					"cyan-vivid-950" => "#004D4D", 		  
				),
				"orange" => array( 
					"orange-025" => "#FFFBFA",
					"orange-050" => "#FFEFE6",
					"orange-100" => "#FFD3BA",
					"orange-200" => "#FAB38B",
					"orange-300" => "#EF8E58",
					"orange-400" => "#E67635",
					"orange-500" => "#C65D21",
					"orange-600" => "#AB4E19",
					"orange-700" => "#8C3D10",
					"orange-800" => "#77340D",
					"orange-900" => "#572508",  	  
					"orange-950" => "#340D00",  	  
				),
				"orange-vivid" => array( 
					"orange-vivid-025" => "#FFFBFA",
					"orange-vivid-050" => "#FFE8D9",
					"orange-vivid-100" => "#FFD0B5",
					"orange-vivid-200" => "#FFB088",
					"orange-vivid-300" => "#FF9466",
					"orange-vivid-400" => "#F9703E",
					"orange-vivid-500" => "#F35627",
					"orange-vivid-600" => "#DE3A11",
					"orange-vivid-700" => "#C52707",
					"orange-vivid-800" => "#AD1D07",
					"orange-vivid-900" => "#841003",  	  
					"orange-vivid-950" => "#4D0900",  	  
				),
				"purple-vivid" => array( 
					"purple-vivid-025" => "#FDFAFF",
					"purple-vivid-050" => "#F2EBFE",
					"purple-vivid-100" => "#DAC4FF",
					"purple-vivid-200" => "#B990FF",
					"purple-vivid-300" => "#A368FC",
					"purple-vivid-400" => "#9446ED",
					"purple-vivid-500" => "#8719E0",
					"purple-vivid-600" => "#7A0ECC",
					"purple-vivid-700" => "#690CB0",
					"purple-vivid-800" => "#580A94",
					"purple-vivid-900" => "#44056E",   	  
					"purple-vivid-950" => "#2C004D",   	  
				),
				"magenta" => array( 
					"magenta-025" => "#FEFAFF",
					"magenta-050" => "#F5E1F7",
					"magenta-100" => "#ECBDF2",
					"magenta-200" => "#CE80D9",
					"magenta-300" => "#BB61C7",
					"magenta-400" => "#AD4BB8",
					"magenta-500" => "#A23DAD",
					"magenta-600" => "#90279C",
					"magenta-700" => "#7C1A87",
					"magenta-800" => "#671270",
					"magenta-900" => "#4E0754",   	  
					"magenta-950" => "#2E0033",   	  
				),
				"custom-1" => array( 
					"custom-1-025" => "#FCFBFF",
					"custom-1-050" => "#E8DEFF",
					"custom-1-100" => "#D4C3FF",
					"custom-1-200" => "#C2ACFC",
					"custom-1-300" => "#B197F5",
					"custom-1-400" => "#A185EC",
					"custom-1-500" => "#9376df",
					"custom-1-600" => "#7A5DC9",
					"custom-1-700" => "#6346B0",
					"custom-1-800" => "#6346B0",
					"custom-1-900" => "#4D3294",   	  
					"custom-1-950" => "#382170",   	  
				),
				"custom-2" => array( 
					"custom-2-025" => "#FBFCFE",
					"custom-2-050" => "#F0F4F8",
					"custom-2-100" => "#D9E2EC",
					"custom-2-200" => "#BCCCDC",
					"custom-2-300" => "#9FB3C8",
					"custom-2-400" => "#829AB1",
					"custom-2-500" => "#627D98",
					"custom-2-600" => "#486581",
					"custom-2-700" => "#334E68",
					"custom-2-800" => "#243B53",
					"custom-2-900" => "#102A43",
					"custom-2-950" => "#152636", 	  
				),
				"custom-3" => array( 
					"custom-3-025" => "#FCFBFE",
					"custom-3-050" => "#E8DEFE",
					"custom-3-100" => "#D4C3FE",
					"custom-3-200" => "#C2ACFB",
					"custom-3-300" => "#B197F4",
					"custom-3-400" => "#A185EB",
					"custom-3-500" => "#9376dE",
					"custom-3-600" => "#7A5DC8",
					"custom-3-700" => "#6346B1",
					"custom-3-800" => "#6346B1",
					"custom-3-900" => "#4D3293",   	  
					"custom-3-950" => "#382171",     	  
				),
			); 

			$custom_colors = json_decode(get_theme_mod( 'custom_colors', '' ), true);
			if($custom_colors)
				$static_colors = array_merge($static_colors, $custom_colors);
			//print_r($custom_colors);die;

			

			return $static_colors;
		}

		public function hex2rgbaDB($color, $opacity = false) {
		
			$default = 'rgb(0,0,0)';
		
			//Return default if no color provided
			if(empty($color))
				return $default; 
		
				//Sanitize $color if "#" is provided 
				if ($color[0] == '#' ) {
					$color = substr( $color, 1 );
				}
		
				//Check if color has 6 or 3 characters and get values
				if (strlen($color) == 6) {
						$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
				} elseif ( strlen( $color ) == 3 ) {
						$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
				} else {
						return $default;
				}
		
				//Convert hexadec to rgb
				$rgb =  array_map('hexdec', $hex);
				$output = 'rgba('.implode(", ",$rgb);
				
				return $output;
		}

		public function output_html( $str ) {
		    return wp_kses( $str, array( 
		    'a' => array(
		        'href' => array(),
		        'title' => array()
		    ),
		    'br' => array(),
		    'b' => array(),
		    'tr' => array(),
		    'th' => array(),
		    'td' => array(),
		    'em' => array(),
		    'strong' => array(),
		    'span' => array(
		        'href' => array(),
		        'class' => array(),
		    ),
		    'div' => array(
		        'id' => array(),
		        'class' => array(),
		    ),
		    ) );
		}

		static public function strposa($haystack, $needle, $offset=0) {

            if(!is_array($needle)) $needle = array($needle);
            foreach($needle as $query) {
                if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
            }
            return false;
        }

        static public function get_css_colors($colors_orr, $colors_typ, $colors_opa, $colors_arr, $css_rules){

            $all_classes = '';
            $i = 0;
            while ($i < sizeof($colors_opa)) {

                $handle = fopen(get_template_directory_uri() .'/style.css', 'r');
                $valid = false; // init as false
                $handle_buffer = ''; 
                $classess = '';
                while (($buffer = fgets($handle)) !== false) {

                    $handle_buffer .= $buffer;
                    $pos = 0;
                    $pos1 = strpos($handle_buffer, $colors_orr[$i], $pos);
                    $pos2 = strpos($handle_buffer, '}', $pos1);
                    if ( $pos1 !== false && $pos2 !== false ) {

                        $pos3 = strrpos($handle_buffer, '@media', -5);
                        $start = strrpos($handle_buffer, '}',-5);
                        $end = strrpos($handle_buffer, '}');
                        $class = substr($handle_buffer, $start, $end-$start+1);
            
                        //remove not required tags
                        $handle_buffer = '';
                        $classess .= ltrim($class,'}'); 

                        if ( $pos3 !== false){

                            $classess .= '}';
                            //$class = "\n".'@media (){'.$class;
                        }
                    }       
                }
                fclose($handle);
                $all_classes .= $classess;

                $i++;
            }

            $css_arr = explode("\n", $all_classes); 
            $css_arr_filtered = [];
            $i = 0;
            while ($i<sizeof($css_arr)){

                if ( Kenzap_Design_System::strposa($css_arr[$i], $css_rules, 0) !== false ){
                    $css_arr_filtered[] = $css_arr[$i];
                }
                $i++;      
            }

            $all_classes = implode("\n", $css_arr_filtered);

            $i = 0;
            while ($i < sizeof($colors_opa)) {

                //get colors from css and override colors
                $id = $colors_arr[$i]; 
                if ( $colors_opa[$i] !== 0 ){
                    $id = Kenzap_Design_System::hex2rgba($colors_arr[$i], $colors_opa[$i]);
                }

                if ( $colors_typ[$i] !== 0 ){
                    $id = Kenzap_Design_System::adjust_brightness($colors_arr[$i], $colors_typ[$i]);
                }

                $all_classes = str_replace($colors_orr[$i], $id, $all_classes); 
                $i++;
            }
            return $all_classes;
		}
		
		static public function hex2rgba( $color, $opacity = false ) {
    
			$default = 'rgb(0,0,0)';
			
			//Return default if no color provided
			if(empty($color))
				return $default;
			
			//Sanitize $color if "#" is provided
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
			
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}
			
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
			
			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
			
			//Return rgb(a) color string
			return $output;
		}
		
		static public function adjust_brightness( $hex, $steps ) {
			// Steps should be between -255 and 255. Negative = darker, positive = lighter
			$steps = max(-255, min(255, $steps));
			
			// Normalize into a six character long hex string
			$hex = str_replace('#', '', $hex);
			if (strlen($hex) == 3) {
				$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
			}
			
			// Split into three parts: R, G and B
			$color_parts = str_split($hex, 2);
			$return = '#';
			
			foreach ($color_parts as $color) {
				$color   = hexdec($color); // Convert to decimal
				$color   = max(0,min(255,$color + $steps)); // Adjust color
				$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
			}
			
			return $return;
		}
	}

}// if !class_exists

/**
 * Loads the main instance of Kenzap_Design_System to have
 * ability extend class functionality
 *
 * @since 1.1.1
 * @return object Kenzap_Design_System
 */

add_action( 'after_setup_theme', 'Kenzap_Design_System', 10 );

if ( ! function_exists( 'Kenzap_Design_System' ) ) :
	function Kenzap_Design_System() {
		Kenzap_Design_System::get_instance();
	}
endif;
