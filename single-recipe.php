<?php get_header();

//
$paged=get_query_var('paged')?get_query_var('paged'):1;

?>


<?php
         $args = array
               (
                'post_type' => 'recipe',//post type name
                'paged'=>$paged,//data is checking in in paged varaible #2
                'posts_per_page' => '1',//how much posts you want
               
                );
$query = new WP_Query($args);//in this #3

if (have_posts()) : while (have_posts()) : the_post(); ?>

<h5 style="margin-left:130px;"><?php the_title(); ?><h5>
 <?php the_content(); ?>
<div style="padding-left:130px;padding-bottom:130px;"> 
<?php the_post_thumbnail('thumbnail');?></div>


<div class="fields"style="margin-left:130px;margin-top:-130px;">


<p> <?php  $name = get_post_meta($post->ID,"wpl_actore_name",true) ?>
                    <?php echo $name ?>
                </p>

               
                <p> <?php  $email = get_post_meta($post->ID,"wpl_actore_email",true) ?>
                    <?php echo $email ?>
                </p>
           
             <p> <?php  $number = get_post_meta($post->ID,"wpl_actore_number",true) ?>
                    <?php echo $number ?>
                </p>
</div>
<?php endwhile;

   //#4  Retrieves paginated links for archive post pages.    
      echo paginate_links(array(
     'total' => $query->max_num_pages
 ));

?>
<?php endif; ?>

<?php get_footer(); ?>

