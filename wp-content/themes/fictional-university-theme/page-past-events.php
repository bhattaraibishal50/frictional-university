<!-- from page past- events -->


<?php 
 
  get_header(); ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri("/assets/images/ocean.jpg") ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"> Past Events</h1>
      <div class="page-banner__intro">
        <p>Recap of our past event</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">
    <?php
    	//custom queriss is needed 

    	$today = date('Ymd');

          $pastEVents = new WP_Query(array(
          	'paged' => get_query_var('paged', 1),
          	// 'posts_per_page' => 1,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            //meta data is extra custom data asocated with post 
            'orderby' => 'meta_value_num', //meta_value is only for alphabate
            //default 'post_date' is we switch random  'rand'
            'order' => 'ASC', //DESC is default 
            //meta_query for custom 
            'meta_query' => array(
                array(
                  'key' => 'event_date', //only event_date
                  'compare' => '<', //is greater then or eqaul to 
                  'value' => $today, //today date
                  'type' => 'numeric'
                )
              )
          ));

      while ($pastEVents->have_posts()){
        $pastEVents->the_post(); ?>

      <div class="event-summary">
               <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                  <span class="event-summary__month">

                    <?php 
                      $eventDate = new DateTime(get_field('event_date'));
                      echo $eventDate->format('M');
                     ?></span>
                  <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>  
                </a>

                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title();  ?></a></h5>
                  <p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
              </div>

    <?php
      }

      //pagination links for ustom queries and custom page
      echo paginate_links(array(
      	'total' => $pastEVents->max_num_pages
      ));
    ?>
  </div>



<?php
  get_footer();
?>