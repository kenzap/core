<?php
/**
 * Kenzap Core Customizer
 *
 * @package Core
 * @since Core 1.0
 */

function core_customize_register( $wp_customize ) {
	
	//Add style section
	$wp_customize->add_section( 'style_section' , array(
		'title'       => esc_html__( 'Fonts', 'core' ),
		'priority'    => 23,
		'description' => esc_html__( 'Adjust various styling features.', 'core' ).' <a href="https://fonts.google.com">'.esc_html__( 'Fonts demo', 'core' ).'</a>',
	) );
	 
    $wp_customize->add_setting( 'font1', array(
		'sanitize_callback' => 'core_sanitize_text',
	) );

	$wp_customize->add_control( 'font1', array(
		'label'     => esc_html__( 'Heading font family', 'core' ),
		'section'   => 'style_section',
		'priority'  => 50,
		'type'      => 'select',
		'choices'   => core_google_fonts(),
	) );

	$wp_customize->add_setting( 'font2', array(
		'sanitize_callback' => 'core_sanitize_text',
	) );

	$wp_customize->add_control( 'font2', array(
		'label'     => esc_html__( 'Body font family', 'core' ),
		'section'   => 'style_section',
		'priority'  => 50,
		'type'      => 'select',
		'choices'   => core_google_fonts(),
	) );

	$wp_customize->add_setting( 'font3', array(
		'sanitize_callback' => 'core_sanitize_text',
	) );
	
	$wp_customize->add_control( 'font3', array(
		'label'     => esc_html__( 'Menu font family', 'core' ),
		'section'   => 'style_section',
		'priority'  => 50,
		'type'      => 'select',
		'choices'   => core_google_fonts(),
	) );

	$wp_customize->add_section( 'templates' , array(
		'title'      => __( 'Templates', 'core' ),
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'template-header', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'template-header', array(
		'label'    => __( 'Header page', 'core' ),
		'section'  => 'templates',
		'type'     => 'dropdown-pages'
	) );

	$wp_customize->add_setting( 'template-footer', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'template-footer', array(
		'label'    => __( 'Footer page', 'core' ),
		'section'  => 'templates',
		'type'     => 'dropdown-pages'
	) );

	$wp_customize->add_setting( 'template-404', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'template-404', array(
		'label'    => __( '404 page', 'core' ),
		'section'  => 'templates',
		'type'     => 'dropdown-pages'
	) );

	// we not interfere with default wp search engine 
	$wp_customize->add_setting( 'template-search', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'template-search', array(
		'label'    => __( 'Search page', 'core' ),
		'section'  => 'templates',
		'type'     => 'dropdown-pages'
	) );

	$wp_customize->add_setting( 'template-archive', array(
		'default'           => '',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'template-archive', array(
		'label'    => __( 'Archive page', 'core' ),
		'section'  => 'templates',
		'type'     => 'dropdown-pages'
	) );

	// Add width scheme setting and control.
	// $wp_customize->add_setting( 'kp_width', array(
	// 	'default'           => 1170,
	// 	'sanitize_callback' => 'core_sanitize_text',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control( 'kp_width', array(
	// 	'label'     => esc_html__( 'Container width', 'core' ),
	// 	'description' => esc_html__( 'Default container width. Setting is ignored with align full/wide layout types.', 'core' ),
	// 	'section'   => 'style_section',
	// 	'priority'  => 10,
	// 	'type'      => 'number',	
	// ) );

	// Add paddings setting and control.
	// $wp_customize->add_setting( 'kp_padding', array(
	// 	'default'           => 15,
	// 	'sanitize_callback' => 'core_sanitize_text',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control( 'kp_padding', array(
	// 	'label'     => esc_html__( 'Container paddings', 'core' ),
	// 	'description' => esc_html__( 'Left & right container paddings. Setting is ignored with align full/wide layout types.', 'core' ),
	// 	'section'   => 'style_section',
	// 	'priority'  => 10,
	// 	'type'      => 'number',	
	// ) );

	// $wp_customize->add_setting( 'kp_palette', array(
	// 	'sanitize_callback' => 'core_sanitize_text',
	// ) );

	// $wp_customize->add_control( 'kp_palette', array(
	// 	'label'     => esc_html__( 'Color palette', 'core' ),
	// 	'section'   => 'style_section',
	// 	'priority'  => 10,
	// 	'type'      => 'select',
	// 	'choices'   => core_palette(),
	// ) );
	
	// //Theme Main Color
	// $wp_customize->add_setting( 'kp_color', array(
	// 	'sanitize_callback' => 'core_sanitize_text',
	// ) );

	// $wp_customize->add_control( new WP_Customize_Color_Control(
	// 	$wp_customize,
	// 	'main_color',
	// 	array(
	// 		'label'      => esc_html__( 'Color', 'core' ),
	// 		'description' => esc_html__( 'Setting is used for outside gutenberg block area. Example: Blog, WooCommerce pages.', 'core' ),
	// 		'section'    => 'style_section',
	// 		'settings'   => 'kp_color',
	// 	) )
	// );

	//Add advanced section
	$wp_customize->add_section( 'advanced_section' , array(
		'title'       => esc_html__( 'Advanced', 'core' ),
		'priority'    => 100,
		'description' => esc_html__( 'Adjust these settings only if you understand what you are doing.', 'core' ).'</a>',
	) );
	
	// Add width scheme setting and control.
	$wp_customize->add_setting( 'jpeg_quality', array(
		'default'           => 85,
		'sanitize_callback' => 'core_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'jpeg_quality', array(
		'label'     => esc_html__( 'Image quality', 'core' ),
		'description' => esc_html__( 'JPEG compression rate. The less the number the lower the quality but faster page loading speed.', 'core' ),
		'section'   => 'advanced_section',
		'priority'  => 10,
		'type'      => 'number',	
	) );
	
	// $wp_customize->add_setting( 'emojis', array(
	// 	'sanitize_callback' => 'core_sanitize_text',
	// ) );

	// $wp_customize->add_control( 'emojis', array(
	// 	'label'     => esc_html__( 'Enable emojis', 'core' ),
	// 	'description' => esc_html__( 'If you use blog actively and user post many comments this feature enables emojis that come by default with WordPress.', 'core' ).'</a>',
	// 	'section'   => 'advanced_section',
	// 	'priority'  => 50,
	// 	'type'      => 'checkbox',
	// 	//'choices'   => core_google_fonts(),
	// ) );
}
add_action( 'customize_register', 'core_customize_register', 11 );

/**
 * Sanitizes text of customizer setting fields.
 *
 * @since Core 1.0
 * @see core_sanitize_text()
 *
 * @return void
 */
function core_sanitize_text( $str ) {
    return wp_kses( $str, array( 
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
    ) );
} 

function core_sanitize_html( $str ) {
    return wp_kses_post( $str );
} 

function core_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Twenty Fifteen 1.5
 * @see core_customize_register()
 *
 * @return void
 */
function core_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function core_google_fonts( ){

	return array(
	'Default','ABeeZee','Abel','Abhaya Libre','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amatica SC','Amethysta','Amiko','Amiri','Amita','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo','Archivo Black','Archivo Narrow','Aref Ruqaa','Arima Madurai','Arimo','Arizonia','Armata','Arsenal','Artifika','Arvo','Arya','Asap','Asap Condensed','Asar','Asset','Assistant','Astloch','Asul','Athiti','Atma','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Bahiana','Baloo','Baloo Bhai','Baloo Bhaijaan','Baloo Bhaina','Baloo Chettan','Baloo Da','Baloo Paaji','Baloo Tamma','Baloo Tammudu','Baloo Thambi','Balthazar','Bangers','Barrio','Basic','Battambang','Baumans','Bayon','Belgrano','Bellefair','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','BioRhyme','BioRhyme Expanded','Biryani','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Bungee','Bungee Hairline','Bungee Inline','Bungee Outline','Bungee Shade','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Cairo','Calligraffitti','Cambay','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Catamaran','Caudex','Caveat','Caveat Brush','Cedarville Cursive','Ceviche One','Changa','Changa One','Chango','Chathura','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Chonburi','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Coiny','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Cormorant','Cormorant Garamond','Cormorant Infant','Cormorant SC','Cormorant Unicase','Cormorant Upright','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','David Libre','Dawning of a New Day','Days One','Dekko','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Dhurjati','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Eczar','El Messiri','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Encode Sans','Encode Sans Condensed','Encode Sans Expanded','Encode Sans Semi Condensed','Encode Sans Semi Expanded','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Exo 2','Expletus Sans','Fanwood Text','Farsan','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Faustina','Federant','Federo','Felipa','Fenix','Finger Paint','Fira Mono','Fira Sans','Fira Sans Condensed','Fira Sans Extra Condensed','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Frank Ruhl Libre','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galada','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gidugu','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Gurajada','Habibi','Halant','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Harmattan','Headland One','Heebo','Henny Penny','Herr Von Muellerhoff','Hind','Hind Guntur','Hind Madurai','Hind Siliguri','Hind Vadodara','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Imprima','Inconsolata','Inder','Indie Flower','Inika','Inknut Antiqua','Irish Grover','Istok Web','Italiana','Italianno','Itim','Jacques Francois','Jacques Francois Shadow','Jaldi','Jim Nightshade','Jockey One','Jolly Lodger','Jomhuria','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kadwa','Kalam','Kameron','Kanit','Kantumruy','Karla','Karma','Katibeh','Kaushan Script','Kavivanar','Kavoon','Kdam Thmor','Keania One','Kelly Slab','Kenia','Khand','Khmer','Khula','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','Kumar One','Kumar One Outline','Kurale','La Belle Aurore','Laila','Lakki Reddy','Lalezar','Lancelot','Lateef','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Lemonada','Libre Barcode 128','Libre Barcode 128 Text','Libre Barcode 39','Libre Barcode 39 Extended','Libre Barcode 39 Extended Text','Libre Barcode 39 Text','Libre Baskerville','Libre Franklin','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Mada','Magra','Maiden Orange','Maitree','Mako','Mallanna','Mandali','Manuale','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Martel','Martel Sans','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Meera Inimai','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miriam Libre','Mirza','Miss Fajardose','Mitr','Modak','Modern Antiqua','Mogra','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Mukta','Mukta Mahee','Mukta Malar','Mukta Vaani','Muli','Mystery Quest','NTR','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Nunito Sans','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Overpass','Overpass Mono','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Padauk','Palanquin','Palanquin Dark','Pangolin','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Pattaya','Patua One','Pavanam','Paytone One','Peddana','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Poppins','Port Lligat Sans','Port Lligat Slab','Pragati Narrow','Prata','Preahvihear','Press Start 2P','Pridi','Princess Sofia','Prociono','Prompt','Prosto One','Proza Libre','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Rajdhani','Rakkas','Raleway','Raleway Dots','Ramabhadra','Ramaraja','Rambla','Rammetto One','Ranchers','Rancho','Ranga','Rasa','Rationale','Ravi Prakash','Redressed','Reem Kufi','Reenie Beanie','Revalia','Rhodium Libre','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Mono','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Rozha One','Rubik','Rubik Mono One','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sahitya','Sail','Saira','Saira Condensed','Saira Extra Condensed','Saira Semi Condensed','Salsa','Sanchez','Sancreek','Sansita','Sarala','Sarina','Sarpanch','Satisfy','Scada','Scheherazade','Schoolbell','Scope One','Seaweed Script','Secular One','Sedgwick Ave','Sedgwick Ave Display','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Shrikhand','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slabo 13px','Slabo 27px','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Source Serif Pro','Space Mono','Special Elite','Spectral','Spicy Rice','Spinnaker','Spirax','Squada One','Sree Krushnadevaraya','Sriracha','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Suez One','Sumana','Sunshiney','Supermercado One','Sura','Suranna','Suravaram','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Taviraj','Teko','Telex','Tenali Ramakrishna','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tillana','Timmana','Tinos','Titan One','Titillium Web','Trade Winds','Trirong','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vesper Libre','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Work Sans','Yanone Kaffeesatz','Yantramanav','Yatra One','Yellowtail','Yeseva One','Yesteryear','Yrsa','Zeyada','Zilla Slab','Zilla Slab Highlight',
	);
}

// function core_palette( ){

// 	return array(
// 	'Cyan & Indigo','Cyan & Pink','Cyan & Red','Cyan & Yellow','Blue & Cyan','Blue & Red','Yellow & Cyan','Yellow & Red','Purple & Light Blue','Purple & Red Vivid','Purple & Yellow Vivid','Teal & Light Blue','Teal & Red Vivid','Teal & Yellow Vivid','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura'
// 	);
// }