<?php get_header();?>


    <!-- s-content
    ================================================== -->
    <section class="s-content">        
        <h2 class="text-center">
            <?php _e("Languages: ", "philosophy").single_term_title(); ?>
        </h2>
        <div class="text-center" style="padding-bottom:40px">
            <?php
            $term = get_queried_object();
            $term_meta = get_term_meta($term->term_id, 'language_featured_image', true);
            if(isset($term_meta['featured_image']) && $term_meta['featured_image'] > 0){
                // echo wp_get_attachment_image($term_meta['featured_image'], 'medium');
                $langluage_image = wp_get_attachment_image_url( $term_meta['featured_image'], 'medium' );
                ?>
                <img src="<?php echo esc_attr($langluage_image);?>" width="50" alt="<?php echo $term->name;?>">
                <?php                
            }
            ?>
        </div>
        <div class="row masonry-wrap">
            <div class="masonry">

                <div class="grid-sizer"></div>

                <?php
                    while(have_posts()){
                        the_post();
                        get_template_part("template-parts/post-formats/post", get_post_format());
                    }
                ?>

            </div> <!-- end masonry -->
        </div> <!-- end masonry-wrap -->

        <div class="row">
            <div class="col-full">
                <nav class="pgn">
                    <?php
                    philosophy_pagination();
                    ?>
                </nav>
            </div>
        </div>

    </section> <!-- s-content -->


<?php get_footer();?>