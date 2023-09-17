<?php get_header();?>


    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow s-content--no-padding-bottom">
        <?php
        while(have_posts()):
            the_post();
        ?>
        <article class="row format-standard">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title();?>
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date"><?php echo esc_html(get_the_date());?></li>
                    <li class="cat">
                        In
                        <?php
                            // echo get_the_category_list(" ");// alternative
                            the_category(" ");
                        ?>
                    </li>
                </ul>
            </div> <!-- end s-content__header -->
    
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                   <?php the_post_thumbnail("large");?>
                </div>
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">

                <?php 
                    the_content();
                    wp_link_pages( );
                ?>


                <div>
                    <h3><?php _e("Chapters:", "philosophy");?></h3>
                    <?php
                        $philosophy_chapter_args = array(
                            'post_type' => 'chapter',  
                            'posts_per_page' => -1,
                            'meta_key' => 'parent_book',
                            'meta_value' => get_the_ID()
                        );
                        $philosophy_chapters = new WP_Query($philosophy_chapter_args);
                        while( $philosophy_chapters->have_posts()){
                            $philosophy_chapters->the_post();
                            ?>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a><br>
                            <?php
                        }
                        wp_reset_query();
                    ?>
                    <h3><?php _e("Chapters (with CMB2 attached post):", "philosophy");?></h3>
                    <?php
                        $philosophy_cmb2_chapters = get_post_meta(get_the_ID(), 'attached_cmb2_attached_posts', true);
                        if($philosophy_cmb2_chapters){
                            foreach($philosophy_cmb2_chapters as $chapter){
                                ?>
                                <a href="<?php echo esc_url(get_the_permalink($chapter));?>"><?php echo esc_html(get_the_title($chapter));?></a><br>
                                <?php
                            }
                        }
                        
                    ?>
                </div>

                <p class="s-content__tags">
                    <span><?php _e("Post Tags", "philosophy");?></span>

                    <span class="s-content__tag-list">
                        <?php 
                            // echo get_the_tag_list(); //alternative
                            the_tags("", "", "");
                        ?>
                    </span>
                </p> <!-- end s-content__tags -->

                <p class="s-content__tags">
                    <span><?php _e("Language Tags", "philosophy");?></span>

                    <span class="s-content__tag-list">
                        <?php 
                            the_terms(get_the_ID(), 'language', '', '', '');
                        ?>
                    </span>
                </p> <!-- end s-content__tags -->

                <div class="s-content__author">
                    <!-- <img src="images/avatars/user-03.jpg" alt=""> -->
                    <?php
                      echo get_avatar(get_the_author_meta("ID"));
                    ?>

                    <div class="s-content__author-about">
                        <h4 class="s-content__author-name">
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta("ID")));?>">
                                <?php the_author_meta("display_name");?>
                            </a>
                        </h4>
                    
                        <p>
                            <?php the_author_meta("description");?>
                        </p>
                        <?php
                            // if(function_exists("the_field")):
                        ?>
                        <ul class="s-content__author-social">
                            <?php 
                                $philosophy_author_facebook = get_field("facebook", "user_".get_the_author_meta("ID"));
                                $philosophy_author_twitter = get_field("twitter", "user_".get_the_author_meta("ID"));
                                $philosophy_author_instagram = get_field("instagram", "user_".get_the_author_meta("ID"));
                            ?>
                            <?php if($philosophy_author_facebook): ?>
                                <li><a href="<?php echo esc_url($philosophy_author_facebook);?>" target="_blank">Facebook</a></li>
                            <?php endif;?>
                            <?php if($philosophy_author_twitter): ?>
                                <li><a href="<?php echo esc_url($philosophy_author_twitter);?>" target="_blank">Twitter</a></li>
                            <?php endif;?>
                            <?php if($philosophy_author_instagram): ?>
                                <li><a href="<?php echo esc_url($philosophy_author_instagram);?>" target="_blank">Instagram</a></li>
                            <?php endif;?>
                        </ul>
                        <?php
                            // endif;
                        ?>
                    </div>
                </div>

                <div class="s-content__pagenav">
                    <div class="s-content__nav">
                        <div class="s-content__prev">
                            <?php 
                            $philosophy_prev_post = get_previous_post();
                            if($philosophy_prev_post){
                                ?>
                                <a href="<?php echo esc_url(get_the_permalink($philosophy_prev_post));?>" rel="prev">
                                    <span><?php _e("Previous Post", "philosophy");?></span>
                                    <?php echo esc_html(get_the_title( $philosophy_prev_post));?>
                                </a>
                                <?php
                            }
                            ?>
                            
                        </div>
                        <div class="s-content__next">
                        <?php 
                        $philosophy_next_post = get_next_post();
                        if($philosophy_next_post){
                            ?>
                            <a href="<?php echo esc_url(get_the_permalink($philosophy_next_post));?>" rel="next">
                                <span><?php _e("Next Post", "philosophy");?></span>
                                <?php echo esc_html(get_the_title( $philosophy_next_post));?>
                            </a>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div> <!-- end s-content__pagenav -->

            </div> <!-- end s-content__main -->

        </article>


        <!-- comments
        ================================================== -->
            <?php 
                if(!post_password_required()){
                    comments_template();
                }
            ?>
            
        <?php endwhile;?>
    </section> <!-- s-content -->


<?php get_footer();?>