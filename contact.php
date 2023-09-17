<?php 
/**
 * Template Name: Contact Page
 */
the_post();
get_header();

?>


<!-- s-content
================================================== -->
<section class="s-content s-content--narrow">
    <article class="row format-standard">

        <div class="s-content__header col-full">
            <h1 class="s-content__header-title">
                <?php the_title();?>
            </h1>
        </div> <!-- end s-content__header -->

        <div class="s-content__media col-full">
            <?php 
                if(is_active_sidebar('contact-maps')){
                    dynamic_sidebar('contact-maps');
                }
            ?>
            <!-- <div id="map-wrap">
                <div id="map-container"></div>
                <div id="map-zoom-in"></div>
                <div id="map-zoom-out"></div>
            </div>  -->
        </div> <!-- end s-content__media -->

        <div class="col-full s-content__main">

            <?php the_content();?>
            <div class="row">
                <?php 
                if(is_active_sidebar('contact-info')){
                    dynamic_sidebar('contact-info');
                }
                ?>
            </div> <!-- end row -->

            <h3>
                <?php get_field('form_title') ? the_field('form_title') : '';?>
            </h3>
            
            <?php
                if(function_exists("the_field")){
                    if(get_field('contact_form_shortcode')){
                       echo do_shortcode(get_field('contact_form_shortcode'));
                    }
                }
                
            ?>
             <!-- end form -->

        </div> <!-- end s-content__main -->
    </article>
</section> <!-- s-content -->


<?php get_footer();?>

