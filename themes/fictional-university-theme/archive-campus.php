<?php

get_header();
pageBanner(array(
  "title"=> "Our Campuses",
  "subtitle"=> "We provide best campus with include all facilities...",
));
 ?>


<div class="container container--narrow page-section">

<ul class="link-list min-list">

<?php
  while(have_posts()) {
    the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title();
    $mapLocation = get_field('map_location');
    print_r($mapLocation);
     ?></a></li>
  <?php }
  echo paginate_links();
?>
</ul>



</div>

<?php get_footer();

?>