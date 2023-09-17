<?php
require_once get_theme_file_path("/inc/tgm.php");
require_once get_theme_file_path("/inc/attachments.php");
require_once get_theme_file_path("/inc/cmb2-attached-posts.php");
require_once get_theme_file_path("/widgets/social-icons-widget.php");

if ( ! isset( $content_width ) ) $content_width = 960;

if(site_url() == "http://localhost/theme_development"){
    define("VERSION", time());
}else{
    define("VERSION", wp_get_theme()->get('Version'));
}


function philosophy_theme_setup(){
    load_theme_textdomain("philosophy");
    add_theme_support("post-thumbnails");
    add_theme_support("custom-logo");
    add_theme_support("title-tag");
    add_theme_support( 'automatic-feed-links' );
    add_theme_support('html5', array('search-form', 'comment-list'));
    add_theme_support( "post-formats", array("image", "gallery", "quote", "audio", "video", "link") );
    add_editor_style("/assets/css/editor-style.css");

    // Single menu register
    register_nav_menu("topmenu", __("Top Menu", "philosophy"));
    // multiple menu register
    register_nav_menus(array(
        "footer-left" => __("Footer Left Menu", "philosophy"),
        "footer-middle" => __("Footer Middle Menu", "philosophy"),
        "footer-right" => __("Footer Right Menu", "philosophy"),
    ));

    add_image_size("philosophy-home-square", 400, 400, true);
}
add_action("after_setup_theme", "philosophy_theme_setup");

function philosophy_assets(){
    $theme_version = wp_get_theme()->get('Version');
    wp_enqueue_style("fontawesome-css", get_theme_file_uri("/assets/css/font-awesome/css/font-awesome.min.css"), null, VERSION);
    wp_enqueue_style("fonts-css", get_theme_file_uri("/assets/css/fonts.css"), null, $theme_version);
    wp_enqueue_style("base-css", get_theme_file_uri("/assets/css/base.css"), null, $theme_version);
    wp_enqueue_style("vendor-css", get_theme_file_uri("/assets/css/vendor.css"), null, $theme_version);
    wp_enqueue_style("main-css", get_theme_file_uri("/assets/css/main.css"), null, $theme_version);
    wp_enqueue_style("philosophy-css", get_stylesheet_uri(), null, VERSION);

    wp_enqueue_script("modernizr-js", get_theme_file_uri("/assets/js/modernizr.js"), null, $theme_version);
    wp_enqueue_script("pace-js", get_theme_file_uri("/assets/js/pace.min.js"), null, $theme_version);
    
    // footer Scripts
    wp_enqueue_script("plugins-js", get_theme_file_uri("/assets/js/plugins.js"), array("jquery"), $theme_version, true);
    
    if ( is_singular() ) {
        wp_enqueue_script( "comment-reply" );
    }
    wp_enqueue_script("main-js", get_theme_file_uri("/assets/js/main.js"), array("jquery"), VERSION, true);
}
add_action("wp_enqueue_scripts", "philosophy_assets");

// plugable function
if(!function_exists("philosophy_pagination")){
    function philosophy_pagination(){
        global $wp_query;
        if($wp_query->max_num_pages < 2 ){
            return;
        }
        $links = paginate_links(array(
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'type' => 'list',
            'mid_size' => apply_filters("philosophy_pagination_mid_size", 3),
        ));
        $links = str_replace("page-numbers", "pgn__num", $links);
        $links = str_replace("<ul class='pgn__num'>", "<ul>", $links);
        $links = str_replace("next pgn__num", "pgn__next", $links);
        $links = str_replace("prev pgn__num", "pgn__prev", $links);
        echo wp_kses_post($links);
    }
}

remove_action("term_description", "wpautop");

function philosophy_widgets() {
	register_sidebar( array(
		'name'          => __( 'About Us Page', 'philosophy' ),
		'id'            => 'about-us',
		'description'   => __( 'Widgets in this area will be shown on about us page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col-block">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="quarter-top-margin">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Page Maps Section', 'philosophy' ),
		'id'            => 'contact-maps',
		'description'   => __( 'Widgets in this area will be shown on Contact page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class=" %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Page Information Section', 'philosophy' ),
		'id'            => 'contact-info',
		'description'   => __( 'Widgets in this area will be shown on Contact page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col-six tab-full">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Before Footer Section', 'philosophy' ),
		'id'            => 'before-footer-right',
		'description'   => __( 'before footer section right side', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
    register_sidebar(array(
        'name'          => __("Our Newsletter on Footer", "philosophy"),
        'id'            => 'footer-our-newsletter',
        'description'   => __("Our Newsletter on footer last column", "philosophy"),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>'
    ));
    register_sidebar(array(
        'name'          => __("Footer Bottom", "philosophy"),
        'id'            => 'footer-bottom',
        'description'   => __("Footer Bottom", "philosophy"),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => ''
    ));
	register_sidebar( array(
		'name'          => __( 'Header Section', 'philosophy' ),
		'id'            => 'header-section',
		'description'   => __( 'Widgets in this area will be shown on Header Section.', 'philosophy' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action("widgets_init", "philosophy_widgets");


function philosophy_search_form($form){
    $homedir = home_url("/");
    $label = __("Search for:", "philosophy");
    $button_label = __("Search", "philosophy");
    $post_type = <<<PT
        <input type="hidden" name="post_type" value="post"/>
    PT;
    if(is_post_type_archive('book')){
        $post_type = <<<PT
        <input type="hidden" name="post_type" value="book"/>
    PT;
    }
    $newform = <<<FORM
        <form role="search" method="get" class="header__search-form" action="{$homedir}">
            <label>
                <span class="hide-content">{$label}</span>
                <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="{$label}" autocomplete="off">
            </label>
            {$post_type}
            <input type="submit" class="search-submit" value="{$button_label}">
        </form>
    FORM;
    return $newform;
}
add_filter("get_search_form", "philosophy_search_form");

// Custom Action Hook
function category_before_title1(){
    echo "<p>Before Title 1</p>";
}
add_action("philosopy_before_category_title", "category_before_title1");

function category_before_title2(){
    echo "<p>Before Title 2</p>";
}
add_action("philosopy_before_category_title", "category_before_title2", 11);

function category_before_title3(){
    echo "<p>Before Title 3</p>";
}
add_action("philosopy_before_category_title", "category_before_title3", 8);



function category_after_title(){
    echo "<p>After Title</p>";
}
add_action("philosopy_after_category_title", "category_after_title");

function category_after_description(){
    echo "<p>After description</p>";
}
add_action("philosopy_after_category_description", "category_after_description");

// Remove action
remove_action("philosopy_before_category_title", "category_before_title1");
remove_action("philosopy_before_category_title", "category_before_title2", 11);
remove_action("philosopy_before_category_title", "category_before_title3", 8);
remove_action("philosopy_after_category_title", "category_after_title");
remove_action("philosopy_after_category_description", "category_after_description");


// This function were not worked. need to check later.
function begaining_category_page($category_title){
    // echo $category_title;
    if($category_title == "Life"){
        $visit_count = get_option("category_life");
        $visit_count = $visit_count ? $visit_count : 0;
        $visit_count++;
        update_option("category_life", $visit_count);
    }
}
add_action("philosopy_category_page", "begaining_category_page");


// Custom Filters
function uppercase_text($param1, $param2, $param3){
   return ucwords($param1)." ".strtoupper($param2)." ".ucwords($param3);
}
add_filter("philosophy_text", "uppercase_text", 10, 3);

function pagination_mid_size(){
    return 4;
}
add_filter("philosophy_pagination_mid_size", "pagination_mid_size");

function philosophy_home_banner_class($class_name){
    if(is_home()){
        return $class_name;
    }else{
        return "";
    }
}
add_filter("philosophy_home_banner_class", "philosophy_home_banner_class");


function philosophy_cpt_slug_fix($post_link, $id) {
    $p = get_post($id);
    if (is_object($p) && 'chapter' == get_post_type($id)) {
        $parent_post_id = get_field('parent_book', $id); // Include $id to specify the post ID
        if ($parent_post_id) {
            $parent_post = get_post($parent_post_id);
            if ($parent_post) {
                $post_link = str_replace("%book%", $parent_post->post_name, $post_link);
            }
        }
    } else {
        return $post_link; // Return unmodified permalink for other cases
    }
    return $post_link;
}

add_filter('post_type_link', 'philosophy_cpt_slug_fix', 1, 2);

function philosophy_footer_language_heading($title){
    if(is_post_type_archive('book') || is_tax('language')){
        $title = __('Languages', 'philosophy');
    }
    return $title;
}

add_filter('philosophy_footer_tag_heading', 'philosophy_footer_language_heading');

function philosophy_footer_language_items($tags){
    if(is_post_type_archive('book') || is_tax('language')){
        $tags = get_terms(array(
            'taxonomy' => 'language',
            'hide_empty' => true,
        ));
    }
    return $tags;
}
add_filter('philosophy_footer_tag_items', 'philosophy_footer_language_items');