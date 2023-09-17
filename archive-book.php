<?php get_header();?>


    <!-- s-content
    ================================================== -->
    <section class="s-content">
        <div class="container text-center">
            <h2 class="pb-5"><?php _e("All Books", "philosophy")?></h2>
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