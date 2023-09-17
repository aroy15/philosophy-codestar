<?php
/**
 * Template Name: Tax Query Example
 */

$philosophy_args_query = array(
    'post_type' => 'book',
    'posts_per_page' => -1,
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'relation' => 'AND',
            array(
            'taxonomy' => 'language',
            'field' => 'slug',
            'terms' => array('english'),
            ),
            array(
                'taxonomy' => 'language',
                'field' => 'slug',
                'terms' => array('bangla'),
                'operator' => 'NOT IN'
            )
        ),
        array(
            'taxonomy' => 'genre',
            'field' => 'slug',
            'terms' => 'horror'
        )
    )
);
$philosophy_tag_query  = new WP_Query($philosophy_args_query);
?>

<?php get_header();?>


    <!-- s-content
    ================================================== -->
    <section class="s-content">
        <h2 class="text-center"><?php the_title(); ?></h2>
        <div class="row masonry-wrap">
            <div class="masonry">

                <div class="grid-sizer"></div>

                <?php
                    while($philosophy_tag_query->have_posts()){
                        $philosophy_tag_query->the_post();
                        get_template_part("template-parts/post-formats/post", get_post_format());
                    }
                    wp_reset_query();
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