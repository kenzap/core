<?php $buffer = get_transient( 'core_buffer' );

if(is_customize_preview())
    $buffer = '';
    
//$buffer = '';

if( '' != $buffer ){
     wp_add_inline_style( 'core-style', $buffer );
     wp_add_inline_style( 'core-style-admin', get_transient( 'core_buffer_admin' ) );
}else{

    //theme default master colors
    $core_color1 = '#e478a7';
    $core_color_text1 = '#333333';
    $core_color_text2 = 'rgba(51, 51, 51, 0.7)';

    // get settings
    if ( get_theme_mod( 'kp_color' ) ) : $core_color1 = get_theme_mod( 'kp_color' ); endif;
    if ( get_theme_mod( 'kp_color_text1' ) ) : $core_color_text1 = get_theme_mod( 'kp_color_text1' ); endif;
    if ( get_theme_mod( 'kp_color_text2' ) ) : $core_color_text2 = get_theme_mod( 'kp_color_text2' ); endif;
    $kp_button   = get_theme_mod( 'kp_button', '' );
    $kp_button_e = get_theme_mod( 'kp_button_e', '' );
    $font1 = get_theme_mod( 'font1', '' );
    $font2 = get_theme_mod( 'font2', '' );
    $font3 = get_theme_mod( 'font3', '' );
    $kp_font = get_theme_mod( 'kp_font', '' );
    $gfa = core_google_fonts();
    $paddings = get_theme_mod( 'kp_padding', '15' );

    // frontend
    ob_start();

    // woocommerce
    if ( class_exists( 'WooCommerce' ) ){ ?>
    
        .woocommerce .product-categories li:hover,
        .woocommerce .product-categories a:hover,
        .woocommerce ul.cart_list li a:hover, 
        .woocommerce ul.product_list_widget li a:hover,
        .woocommerce #respond input#submit, 
        .woocommerce a.button, 
        .woocommerce button.button, 
        .woocommerce input.button,
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li.active a,
        .woocommerce nav.woocommerce-pagination ul li span.current,
        .woocommerce-info:before,
        .shop_table .coupon .button,
        .shop_table .actions .button,
        .shop_table .shipping-calculator-form .button,
        .woocommerce input.txtacrescimo,
        .woocommerce .shop_table .product-price .woocommerce-Price-amount,
        .woocommerce .cart-steps ul.steps a,
        .woocommerce .cart-steps ul.steps a span,
        .woocommerce button.button.alt,
        .woocommerce input.button.alt ,
        .woocommerce-message:before,
        .product-single .woocommerce-Price-amount,
        .woocommerce ul.products li.product span.woocommerce-Price-amount ,
		.woocommerce ul.products li.product a.button{
            color:<?php echo esc_attr( $core_color1 ); ?>
        }

        .woocommerce #respond input#submit, 
        .woocommerce a.button, 
        .woocommerce button.button, 
        .woocommerce input.button,
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li.active a,
        .woocommerce nav.woocommerce-pagination ul li span.current,
        .shop_table .coupon .button,
        .shop_table .actions .button,
        .shop_table .shipping-calculator-form .button,
        .woocommerce .cart-steps ul.steps a span,
        .woocommerce button.button.alt,
        .woocommerce input.button.alt,
        .woocommerce ul.products li.product a.button{
            border-color:<?php echo esc_attr( $core_color1 ); ?>
        }

        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
        .woocommerce #respond input#submit:hover, 
        .woocommerce a.button:hover, 
        .woocommerce button.button:hover, 
        .woocommerce input.button:hover,
        .shop_table .coupon .button:hover,
        .shop_table .actions .button:hover,
        .woocommerce-cart .wc-proceed-to-checkout a.button.alt,
        .woocommerce .cart-steps ul.steps .current a span,
        .woocommerce .cart-steps ul.steps a:hover span,
        .woocommerce button.button.alt:hover,
        .woocommerce input.button.alt:hover,
        .woocommerce ul.products li.product a.button:hover{
            background-color:<?php echo esc_attr( $core_color1 ); ?>
        }

        .woocommerce-info,
        .woocommerce-message{
            border-top-color:<?php echo esc_attr( $core_color1 ); ?>
        }

        .shop_table .product-thumbnail{width:0px;min-width:0px!important;}

        <?php if($kp_button != ''){
        
            switch($kp_button){
                case 'square': echo '.woocommerce-page.kenzap button.button,.woocommerce-page.kenzap a.button,.woocommerce-page.kenzap input#coupon_code,.kenzap .comment-respond .submit,.kenzap .comment-list .reply a{border-radius:0px!important;}';  break;
                case 'round1': echo '.woocommerce-page.kenzap button.button,.woocommerce-page.kenzap a.button,.woocommerce-page.kenzap input#coupon_code,.kenzap .comment-respond .submit,.kenzap .comment-list .reply a{border-radius:5px!important;}'; break;
                case 'round2': echo '.woocommerce-page.kenzap button.button,.woocommerce-page.kenzap a.button,.woocommerce-page.kenzap input#coupon_code,.kenzap .comment-respond .submit,.kenzap .comment-list .reply a{border-radius:200px!important;}#coupon_code{padding-left:25px;}'; break;
            }
        } ?>

	<?php } ?>

        blockquote cite,
        blockquote small,
        body,
        button,
        input,
        select,
        textarea,
        input:focus,
        textarea:focus,
        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],
        a,
        .image-navigation a:hover,
        .image-navigation a:focus,
        .comment-navigation a:hover,
        .comment-navigation a:focus,
        .comment-metadata a:hover,
        .comment-metadata a:focus,
        .pingback .edit-link a:hover,
        .pingback .edit-link a:focus,
        .comment-list .reply a:hover,
        .comment-list .reply a:focus{
            color: <?php echo esc_attr( $core_color_text1 ); ?>
        }

        a:hover, 
        a:focus,
        blockquote{
            color: <?php echo esc_attr( $core_color_text2 ); ?>
        }

        ::-webkit-input-placeholder {
            color: <?php echo esc_attr( $core_color_text2 ); ?>
        }

        :-moz-placeholder {
            color: <?php echo esc_attr( $core_color_text2 ); ?>
        }

        ::-moz-placeholder {
            color: <?php echo esc_attr( $core_color_text2 ); ?>
        }

        :-ms-input-placeholder{
            color: <?php echo esc_attr( $core_color_text2 ); ?>
        }

        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],
        .logged-in-as a:hover,
        .comment-list .reply a:hover,
        .comment-list .reply a:focus,
        .comment-metadata a:hover,
        .pingback .edit-link a:hover,
        .page-links a,
        .taxonomy-description a,
        .entry-footer a:hover,
        .author-description a{
            border-color: <?php echo esc_attr( $core_color_text1 ); ?>
        }

        .page-links a,
        .sticky-post{
            background-color: <?php echo esc_attr( $core_color_text1 ); ?>
        }

        nav.pagination a.page-numbers:hover,
        .entry-meta :before{
            color:<?php echo esc_attr( $core_color1 ); ?>
        }

        nav.pagination .nav-links > .current, .kp-pagination > span.current, .kp-pagination > a.page-numbers:hover, .kp-pagination > a.post-page-numbers:hover{
            color:<?php echo esc_attr( $core_color1 ); ?>;
            border-color:<?php echo esc_attr( $core_color1 ); ?>;
        }

        .sticky-post{
            background-color:<?php echo esc_attr( $core_color1 ); ?> 
        }

        .pagination a.page-numbers:hover,
        .pagination a.page-numbers.current,
        blockquote{
            border-color:<?php echo esc_attr( $core_color1 ); ?>
        }

    <?php

    // new font system in use
    if($kp_font!='' && $kp_font!='- Custom Fonts'){

        $kp_font_arr = explode("&", $kp_font);
        $font1N = trim($kp_font_arr[0]);
        $font2N = trim($kp_font_arr[1]);
        $font3N = trim($kp_font_arr[1]);

    // old font system in use
    }else{

        $font1N = $gfa[$font1];
        $font2N = $gfa[$font2];
        $font3N = $gfa[$font3];
    }

    if ( '' != $font1N ){ ?>
      h1, h2, h3, h4, h5, h6, h7, h2 span, h2 strong, h3 span, h1 strong, h3 strong, h4 a, h3 a, h2 a, h1 a{font-family:'<?php echo esc_attr( $font1N ); ?>'!important;}
    <?php }

    if ( '' != $font2N ){ ?>
      body,p,a,div,strong,b,cite,span,button,input,ul li,ul li a{font-family:'<?php echo esc_attr( $font2N ); ?>'!important;}
    <?php }

    if ( '' != $font3N ){ ?>
      .main-nav ul li a, .mobile-nav ul li a{font-family:'<?php echo esc_attr( $font3N ); ?>'!important;}
    <?php } ?>

    #wpadminbar .ab-icon, #wpadminbar .ab-item:before, #wpadminbar>#wp-toolbar>#wp-admin-bar-root-default .ab-icon, .wp-admin-bar-arrow{
        font-family: dashicons!important;
    }

    .kp-cont{padding-left: <?php echo esc_attr($paddings); ?>px; padding-right: <?php echo esc_attr($paddings); ?>px;}

    @media (min-width: <?php echo intVal(get_theme_mod( 'kp_width', '1170' ))+intVal($paddings)*2; ?>px){
        .kp-cont{
            width:<?php echo get_theme_mod( 'kp_width', '1170' ); ?>px; 
        } 
    }

    <?php // button settings

    if($kp_button != ''){
        
        switch($kp_button){
            case 'square': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:0px}'; break;
            case 'round1': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:8px}'; break;
            case 'round2': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:200px}'; break;
        }

        switch($kp_button_e){
            // case 'gradient1': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:0px}'; break;
            // case 'gradient2': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:10px}'; break;
            case 'border1': echo '.kenzap a.bt1,.kenzap a.bt2{border-left:none!important;border-right:none!important;border-top:none!important;border-bottom-width:4px;border-bottom-style:solid!important;} .kenzap a.bt1h:hover,.kenzap a.bt2h:hover{border:inherit!important;color:initial!important;}'; break;
            case 'border2': echo '.kenzap a.bt1,.kenzap a.bt2{border-left:none!important;border-right:none!important;border-bottom:none!important;border-top-width:4px;border-top-style:solid!important;}'; break;
        }
    }

    $buffer = ob_get_clean();

    // Minify inline CSS
    $buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
    $buffer = str_replace( ': ', ':', $buffer );
    $buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );
    set_transient('core_buffer', $buffer);
    wp_add_inline_style('core-style', $buffer);

    // backend
    ob_start();
    if ( '' != $font1N ){ ?>
        .editor-writing-flow h1, .editor-writing-flow h2, .editor-writing-flow h3, .editor-writing-flow h4, .editor-writing-flow h5, .editor-writing-flow h6, .editor-writing-flow h7, .editor-writing-flow h2 span, .editor-writing-flow h2 strong, .editor-writing-flow h3 span, .editor-writing-flow h1 strong, .editor-writing-flow h3 strong, .editor-writing-flow h4 a, .editor-writing-flow h2 a{font-family:'<?php echo esc_attr( $font1N ); ?>'!important;}
    <?php }

    if ( '' != $font2N ){ ?>
        .editor-writing-flow body, .editor-writing-flow p, .editor-writing-flow a,.editor-writing-flow div,.editor-writing-flow strong,.editor-writing-flow b,.editor-writing-flow cite,.editor-writing-flow span:not(.dashicons),.editor-writing-flow button,.editor-writing-flow input,.editor-writing-flow ul li,.editor-writing-flow ul li a{font-family:'<?php echo esc_attr( $font2N ); ?>'!important;}
    <?php }

    if ( '' != $font3N ){ ?>
        .main-nav ul li a, .mobile-nav ul li a{font-family:'<?php echo esc_attr( $font3N ); ?>'!important;}
    <?php }

    // button settings
    if($kp_button != ''){
        
        switch($kp_button){
            case 'square': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:0px}'; break;
            case 'round1': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:10px}'; break;
            case 'round2': echo '.kenzap a.bt1,.kenzap a.bt2{border-radius:200px}'; break;
        }  ?>
        
    <?php } 

    $buffer = ob_get_clean();

    // Minify inline CSS
    $buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
    $buffer = str_replace( ': ', ':', $buffer );
    $buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );
    set_transient('core_buffer_admin', $buffer);
    wp_add_inline_style('core-style-admin', $buffer);
}


