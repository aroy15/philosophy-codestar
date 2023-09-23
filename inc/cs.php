<?php
define('CS_ACTIVE_FRAMEWORK', true);//default value
define('CS_ACTIVE_METABOX', true);
define('CS_ACTIVE_TAXONOMY', true);//default value
define('CS_ACTIVE_SHORTCODE', true);
define('CS_ACTIVE_CUSTOMIZE', false);//default value


function philosophy_csf_metabox(){
    CSFramework_Taxonomy::instance(array());
    CSFramework_Metabox::instance(array());
    CSFramework_Shortcode_Manager::instance(array());
}
add_action('init', 'philosophy_csf_metabox');

function philosophy_language_featured_image($options){
    $options[]    = array(
        'id'        => 'language_featured_image',
        'taxonomy' => 'language', // or array( 'category', 'post_tag' )
      
        // begin: fields
        'fields'    => array(
          // begin: a field
          array(
            'id'    => 'featured_image',
            'type'  => 'image',
            'title' => 'Featured Image',
          ),
        ), // end: fields
      );
    
    return $options;
}

add_filter('cs_taxonomy_options', 'philosophy_language_featured_image');

function philosophy_page_metabox($options){
    
    $page_id = 0;
    if(isset($_REQUEST['post']) || isset($_REQUEST['post_ID'])){
        $page_id = empty($_REQUEST['post_id']) ? $_REQUEST['post'] : $_REQUEST['post_id'];
    }

    $current_page_template = get_post_meta($page_id, '_wp_page_template', true);
    // Single template checking
    // if('about.php' != $current_page_template){
    //     return $options;
    // }

    // Multiple template checking
    if(!in_array($current_page_template, array('about.php','contact.php'))){
        return $options;
    }


    $options[] = array(
        'id' => 'page-metabox',
        'title' => __('Page Meta Info', 'philosophy'),
        'post_type' => 'page',
        'context' => 'normal',
        'priority' => 'default',
        'sections' => array(
            array(
                'name' => 'page-section1',
                'title' => __('Page Settings', 'philosophy'),
                'icon' => 'fa fa-image',
                'fields' => array(
                    array(
                        'id' => 'page-heading',
                        'type' => 'text',
                        'default' => __('Page Heading', 'philosophy'),
                        'title' => __('Page Heading', 'philosophy')
                    ),
                    array(
                        'id' => 'page-teaser',
                        'type' => 'textarea',
                        'title' => __('Teaser Text', 'philosophy'),
                        'default' => __('Teaser Text', 'philosophy')
                    ),
                    array(
                        'id' => 'custom_color',
                        'type' => 'color_picker',
                        'title' => __('Color Picker Field', 'philosophy'),
                        'default' => '#ff0000',
                    ),
                    array(
                        'id' => 'google_fonts',
                        'type' => 'typography',
                        'title' => __('Typography Field', 'philosophy'),
                        'default' => array(
                            'family' => 'Open Sans',
                            'variant' => '800',
                            'font' => 'google' // this is helper for output
                        ),
                    ),
                    array(
                        'type' => 'subheading',
                        'content' => __('Book Section', 'philosophy')
                    ),
                    array(
                        'id' => 'is-favorite',
                        'type' => 'switcher',
                        'title' => __('Is Favorite', 'philosophy'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'is-favorite-extra',
                        'type' => 'switcher',
                        'title' => __('Extra Check', 'philosophy'),
                        'default' => 0,
                        'dependency' => array('is-favorite', '==', '1')
                    ),
                    // array(
                    //     'id' => 'is-favorite-text',
                    //     'type' => 'text',
                    //     'title' => __('Favorite Text', 'philosophy'),
                    //     'dependency' => array('is-favorite-extra', '==', '1')
                    // ),
                    array(
                        'id' => 'is-favorite-text',
                        'type' => 'text',
                        'title' => __('Favorite Text', 'philosophy'),
                        'dependency' => array('is-favorite|is-favorite-extra', '==|==', '1|1')
                    ),
                    array(
                        'id' => 'suport-language',
                        'type' => 'checkbox',
                        'title' => __('Languages', 'philosophy'),
                        'options' => array(
                            'bangla' => 'Bangla',
                            'english' => 'English',
                            'french' => 'French'
                        )
                    ),
                    array(
                        'id' => 'extra-language-data',
                        'type' => 'text',
                        'title' => __('Extra Data', 'philosophy'),
                        'dependency' => array('suport-language_bangla|suport-language_english', '==|==', '1|1')
                    )
                )
            ),
            array(
                'name' => 'page-section2',
                'title' => __('Page Extra Settings', 'philosophy'),
                'icon' => 'fa fa-book',
                'fields' => array(
                    array(
                        'id' => 'page-heading2',
                        'type' => 'text',
                        'default' => __('Page Heading2', 'philosophy'),
                        'title' => __('Page Heading2', 'philosophy')
                    ),
                    array(
                        'id' => 'page-teaser2',
                        'type' => 'textarea',
                        'default' => __('Teaser Text2', 'philosophy'),
                        'title' => __('Teaser Text2', 'philosophy')
                    ),
                    array(
                        'id' => 'is-favorite2',
                        'type' => 'switcher',
                        'title' => __('Is Favorite2', 'philosophy'),
                        'default' => 1
                    )
                )
            ) 
        )
    );

    return $options;
}
add_filter('cs_metabox_options', 'philosophy_page_metabox');

function philosophy_upload_metabox($options){

    $options[] = array(
        'id' => 'page-upload-metabox',
        'title' => __('Upload Files', 'philosophy'),
        'post_type' => 'page',
        'context' => 'normal',
        'priority' => 'default',
        'sections' => array(
            array(
                'name' => 'page-section1',
                'title' => __('Upload Settings', 'philosophy'),
                'icon' => 'fa fa-image',
                'fields' => array(
                    array(
                        'id' => 'page-upload',
                        'type' => 'upload',
                        'title' => __('Upload Image', 'philosophy'),
                        'settings' =>  array(
                            'upload_type' => 'application/pdf',
                            'button_title' => __('Upload PDF', 'philosophy'),
                            'frame_title' => __('Select an PDF', 'philosophy'),
                            'insert_title' => __('Use this PDF', 'philosophy'),
                        )
                    ),
                    array(
                        'id' => 'page-image',
                        'type' => 'image',
                        'title' => __('Upload Image', 'philosophy'),
                        'add_title' => __('Add An Image', 'philosophy')
                    ),
                    array(
                        'id' => 'page-gallery',
                        'type' => 'gallery',
                        'title' => __('Upload Gallery Images', 'philosophy'),
                        'add_title' => __('Add Images', 'philosophy'),
                        'edit_title' => __('Edit Gallery', 'philosophy'),
                        'clear_title' => __('Clear Gallery', 'philosophy'),
                    ),
                    array(
                        'id' => 'fieldset_1',
                        'type' => 'fieldset',
                        'title' => 'Fieldset Field',
                        'fields' => array(
                            array(
                                'id'=> 'fieldset_1_text',
                                'type' => 'text',
                                'title' => 'Text Field',                                
                            ),
                            array(
                                'id'=> 'fieldset_1_textarea',
                                'type' => 'textarea',
                                'title' => 'Textarea Field',                                
                            )
                        )
                    ),
                    array(
                        'id'              => 'unique_option_901',
                        'type'            => 'group',
                        'title'           => 'Group Field',
                        'button_title'    => 'Add New',
                        'accordion_title' => 'Add New Field',
                        'fields'          => array(
                          array(
                            'id'    => 'featured_posts',
                            'type'  => 'select',
                            'title' => __('Select a book', 'philosophy'),
                            'options' => 'posts',
                            'query_args' => array(
                                'post_type' => 'book',
                                'posts_per_page' => -1,
                                'orderby' => 'post_date',
                                'order' => 'DESC'
                            )
                          )
                        ),
                    ),
                )
            )
        )
    );
    return $options;
}
add_filter('cs_metabox_options', 'philosophy_upload_metabox');

function philosophy_custom_post_types($options){
    $page_id = 0;
    if(isset($_REQUEST['post']) || isset($_REQUEST['post_ID'])){
        $page_id = empty($_REQUEST['post_id']) ? $_REQUEST['post'] : $_REQUEST['post_id'];
    }

    $options[] = array(
        'id' => 'page-custom_post_type',
        'title' => __('Select Post Type', 'philosophy'),
        'post_type' => 'page',
        'context' => 'normal',
        'priority' => 'default',
        'sections' => array(
            array(
                'name' => 'page-section1',
                // 'title' => __('Post Types', 'philosophy'),
                'icon' => 'fa fa-image',
                'fields' => array(
                    array(
                        'id'    => 'cpt_type',
                        'type'  => 'select',
                        'title' => __('Select a custom post type', 'philosophy'),
                        'options' => array(
                            'none' => 'None',
                            'book' => 'Book',
                            'chapter' => 'Chapter',
                        )
                    )
                )
            )
        )
    );

    $page_meta_info = get_post_meta($page_id, 'page-custom_post_type', true);

    if(isset($page_meta_info['cpt_type']) && $page_meta_info['cpt_type'] == 'book'){
        $options[] = array(
            'id' => 'page-custom_post_type_book',
            'title' => __('Options for book', 'philosophy'),
            'post_type' => 'page',
            'context' => 'normal',
            'priority' => 'default',
            'sections' => array(
                array(
                    'name' => 'page-section1',
                    // 'title' => __('Post Types', 'philosophy'),
                    'icon' => 'fa fa-image',
                    'fields' => array(
                        array(
                            'id'    => 'option_book_text',
                            'type'  => 'text',
                            'title' => __('Some book info', 'philosophy')
                        )
                    )
                )
            )
        );
    }

   
    if(isset($page_meta_info['cpt_type']) && $page_meta_info['cpt_type'] == 'chapter'){
        $options[] = array(
            'id' => 'page-custom_post_type_chapter',
            'title' => __('Options for chapter', 'philosophy'),
            'post_type' => 'page',
            'context' => 'normal',
            'priority' => 'default',
            'sections' => array(
                array(
                    'name' => 'page-section1',
                    // 'title' => __('Post Types', 'philosophy'),
                    'icon' => 'fa fa-image',
                    'fields' => array(
                        array(
                            'id'    => 'option_chapter_text',
                            'type'  => 'text',
                            'title' => __('Some chapter info', 'philosophy')
                        )
                    )
                )
            )
        );
    }
    

    return $options;
}
add_filter('cs_metabox_options', 'philosophy_custom_post_types');

function philosophy_cs_google_map($options){
    $options[] = array(
        'name' => 'group_1',
        'title' => 'Group #1',
        'shortcodes' => array(
            array(
                'name' => 'gmap',
                'title' => 'Google Map',
                'fields' => array(
                    array(
                        'id' => 'place',
                        'type' => 'text',
                        'title' => __('Place', 'philosophy'),
                        'help' => __('Enter Place', 'philosophy'),
                        'default' => 'Notre Dame College, Dhaka'
                    ),
                    array(
                        'id' => 'width',
                        'type' => 'text',
                        'title' => 'Width',
                        'default' => '100%'
                    ),
                    array(
                        'id' => 'height',
                        'type' => 'text',
                        'title' => 'Height',
                        'default' => 500
                    ),
                    array(
                        'id' => 'zoom',
                        'type' => 'text',
                        'title' => 'Zoom',
                        'default' => 14
                    )
                )
            )
        )
    );
    return $options;
}
add_filter('cs_shortcode_options', 'philosophy_cs_google_map');

function philosophy_theme_option_init(){
    $settings = array(
        'menu_title' => __('Philosophy Options', 'philosohpy'),
        'menu_type' => 'submenu',
        'menu_parent' => 'themes.php',
        'menu_slug' => 'philosophy_option_panel',
        'framework_title' =>  __('Philosophy Options', 'philosohpy'),
        'menu_icon' => 'dashicons-dashboard',
        'menu_position' => 20,
        'ajax_save' => false,
        'show_reset_all' => true
    );

    $options = philosophy_theme_options();

    new CSFramework($settings, $options);
}
add_action('init', 'philosophy_theme_option_init');

function philosophy_theme_options(){

    $options =  array();
    $options[] = array(
        'name' => 'footer_options',
        'title' => __('Footer Options', 'philosophy'),
        'icon' => 'fa fa-edit',
        'fields' => array(
            array(
                'id' => 'footer_tag',
                'type' => 'switcher',
                'title' => __('Tags Area Visible?', 'philosophy'),
                'default' => 0
            ),
            array(
                'id' => 'social_facebook',
                'type' => 'text',
                'title' => __('Facebook URL', 'philosophy'),
            ),
            array(
                'id' => 'social_twitter',
                'type' => 'text',
                'title' => __('Twitter URL', 'philosophy'),
            ),
            array(
                'id' => 'social_pinterest',
                'type' => 'text',
                'title' => __('Pinterest URL', 'philosophy'),
            )
        )
    );

    $options[] = array(
        'name' => 'section_1',
        'title' => __('Section 1', 'philosophy'),
        'icon' => 'fa fa-wifi',
        'fields' => array(
            array(
                'id' => 'text_option',
                'type' => 'text',
                'title' => __('A Text Option', 'philosophy')
            ),
            array(
                'id' => 'textarea_option',
                'type' => 'textarea',
                'title' => __('A Textarea Option', 'philosophy')
            )
        )
    );

    $options[] = array(
        'name' => 'section_2',
        'title' => __('Section 2', 'philosophy'),
        'icon' => 'fa fa-heart',
        'fields' => array(
            array(
                'id' => 'text_option',
                'type' => 'text',
                'title' => __('A Text Option', 'philosophy')
            )
        )
    );

    return $options;
}
// add_filter('cs_framework_options', 'philosophy_theme_options');