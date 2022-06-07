<?php
/**
 * Template Name: Recipe Book
 */
get_header();  

?>
<div class="search_bar">
    <form action="/" method="get" autocomplete="off">
        <input type="text" name="s" placeholder="Search here" id="keyword" class="input_search" onkeyup="fetch()">
        <button>
            Search
        </button>
    </form>
    <div class="search_result" id="datafetch">
    </div>
</div>
<?php
//#1 url se get karega ye query or agr url se nhi milta to aap 1 set krdo
$paged=get_query_var('paged')?get_query_var('paged'):1;

?>

<div class="wrap">
    <div id="primary" class="content_area">
        <main id="main" class="site-main" role="main" >
            <?php
               $args = array
            (
                'post_type' => 'recipe',//post type name
                'posts_per_page' => '2',//how much posts you want
              //'publish_status' => 'published',
                'paged'=>$paged,//data is checking in in paged varaible #2
               
            );

            $query = new WP_Query($args);//in this #3
           
            if($query->have_posts()) :

                while($query->have_posts()) :

                    $query->the_post();?>
            <b> <h1><?php the_title(); ?></h1></b>
                    <p style="text-align:center;"><?php the_content(); ?></p>
                    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail');?></a>
                   


                    <p> <?php  $name = get_post_meta($post->ID,"wpl_actore_name",true) ?>
                    <?php echo $name ?>
                </p>

               
                <p> <?php  $email = get_post_meta($post->ID,"wpl_actore_email",true) ?>
                    <?php echo $email ?>
                </p>
           
             <p> <?php  $number = get_post_meta($post->ID,"wpl_actore_number",true) ?>
                    <?php echo $number ?>
                </p>
               
            <?php
                endwhile;    
                    //#4  Retrieves paginated links for archive post pages.    
                    echo paginate_links(array(
                    'total' => $query->max_num_pages
                   ));
            endif;    
            ?>
        </main>
    </div>
</div>


<?php

get_footer();

?>