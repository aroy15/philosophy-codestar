<?php
define('CS_ACTIVE_FRAMEWORK', false);
define('CS_ACTIVE_METABOX', true);
define('CS_ACTIVE_TAXONOMY', false);//default value
define('CS_ACTIVE_SHORTCODE', false);//default value
define('CS_ACTIVE_CUSTOMIZE', false);//default value


function philosophy_csf_metabox(){
    CSFramework_Metabox::instance(array());
}
add_action('init', 'philosophy_csf_metabox');

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
                        'default' => __('Teaser Text', 'philosophy'),
                        'title' => __('Teaser Text', 'philosophy')
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

    // $page_meta_info = get_

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

    return $options;
}
add_filter('cs_metabox_options', 'philosophy_custom_post_types');