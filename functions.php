<?php
//************************************************************************************************************************************************************************************************************************************************************************************enqueing scripts in***************************************************** 
function mytheme_enqueue_styles() {

wp_enqueue_script( 'recipe_js', get_stylesheet_directory_uri() . "/recipe.js" ,   array('jquery') );
wp_localize_script( 'recipe_js', 'frontend_ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
wp_enqueue_style( 'child-style', get_stylesheet_uri());   
    // in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
}

    add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );



//*********************************************************************************************************************************************************custom post type start form here***********************************************
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function my_custom_post_recipe() {
//cutom post type
//labels array added inside the function and precedes args array

$labels = array(
'name' => _x( 'recipes', 'post type general name' ),
'singular_name' => _x( 'recipe', 'post type singular name' ),
'add_new' => _x( 'Add New', 'recipe' ),
'add_new_item' => __( 'Add New recipe' ),
'edit_item' => __( 'Edit recipe' ),
'new_item' => __( 'New recipe' ),
'all_items' => __( 'All recipes' ),
'view_item' => __( 'View recipe' ),
'search_items' => __( 'Search recipes' ),
'not_found' => __( 'No recipes found' ),
 'featured_image'        => __( 'recipe Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'recipe' ), 'set_featured_image'    => __( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'recipe' ),
 'remove_featured_image' => __( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'recipe' ),
  'use_featured_image'    => __( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'recipe' ),
 'archives'              => __( 'recipe archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'recipe' ),
 'insert_into_item'      => __( 'Insert into recipe', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'recipe' ),
 'uploaded_to_this_item' => __( 'Uploaded to this recipe', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'recipe' ),
'not_found_in_trash' => __( 'No recipes found in the Trash' ),
'parent_item_colon' => '',
'menu_name' => 'recipes'
);

// args array

$args = array(
'labels' => $labels,
'description' => 'Displays city recipes and their ratings',
'public' => true,
'rewrite' => true,
'rewrite' => array('slug' => 'recipe'),
'menu_position' => 4,
'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments','author' ),
'has_archive' => true,
'taxonomies' => array('spice-book')
);

register_post_type( 'recipe', $args );
}
add_action( 'init', 'my_custom_post_recipe' );






//*************************************************************************************************************************************************************************************************************************************************************************************adding custom metabox***************************************************
function wpl_register_metabox(){

      add_meta_box( "cpt-id", "Actores Details", "wpl_actor_call","recipe","side","high");

 }

 add_action("add_meta_boxes","wpl_register_metabox");



 function wpl_actor_call($post){


?>
    <p>
     <label> Name </label>
<?php  $name = get_post_meta($post->ID,"wpl_actore_name",true) ?>
<input type="text" value="<?php echo $name ?>" name="TxtActoreName" placeholder="name"/>
    </p>

    <p>
     <label> Email </label>
<?php  $email = get_post_meta($post->ID,"wpl_actore_email",true) ?>
<input type="email" value="<?php echo $email ?>" name="TxtActoreEmail" placeholder="email"/>
    </p>
    <p>
     <label> Number </label>
<?php  $email = get_post_meta($post->ID,"wpl_actore_number",true) ?>
<input type="number" value="<?php echo $number ?>" name="TxtActorenumber" placeholder="number"/>
    </p>

<?php

 }

//************************************************************************************************************************************************************************************************************************************************************************** getting data from (custom field) metabox******************************************



 add_action("save_post","wpl_save_values",10,2);

 function wpl_save_values($post_id, $post){

$TxtActoreName = isset($_POST['TxtActoreName'])?$_POST['TxtActoreName']:"";
$TxtActoreEmail = isset($_POST['TxtActoreEmail'])?$_POST['TxtActoreEmail']:"";
$TxtActorenumber = isset($_POST['TxtActorenumber'])?$_POST['TxtActorenumber']:"";


upoldest_post_meta( $post_id,"wpl_actore_name",$TxtActoreName);
upoldest_post_meta( $post_id,"wpl_actore_email",$TxtActoreEmail);
   upoldest_post_meta( $post_id,"wpl_actore_number",$TxtActorenumber);

 }

 // *********************************************************************************************************************************************************************************************************************************************************************************adding columns to post page*********************************************



 add_action( "manage_recipe_posts_columns","rj_custom_columns");


 function rj_custom_columns($columns){


$columns = array(

"cb"=>"<input type='checkbox'/>",
"title" => "recipe title",
"pub_email" => "Publisher email",
"pub_name" => "Publisher name",
"pub_number"=>"Publisher number ",
"oldest" => "oldest"

);

return $columns;

 }

//************************************************************************************************************************************************************************************************************************************************************* adding data to post page from data base according to colmun name*******************************



 add_action( "manage_recipe_posts_custom_column","rj_custom_columns_data",10,2);

 function rj_custom_columns_data($column,$post_id){


switch($column){

case 'pub_email':
$publisher_email = get_post_meta($post_id,"wpl_actore_email",true);
echo $publisher_email;
break;

case 'pub_name':
$publisher_name = get_post_meta($post_id,"wpl_actore_name",true);
echo $publisher_name;
break;
       
case 'pub_number':
$publisher_number = get_post_meta($post_id,"wpl_actore_number",true);
echo $publisher_number;
break;

}

 }
 ////////////////////////////////////////////here search box coding start//////////////////////////////////
 //*****************************************************************************************************************
 //*****************************************************************************************************************
add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    $the_query = new WP_Query( array( 'posts_per_page' => 2, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('recipe') ) );
    

    if( $the_query->have_posts() ) :

    //echo '<ul>';
         ?>

 <div class="wrapper">
    <div class="row">
   <div id="primarys" class="container">
    
    <?php
        while( $the_query->have_posts() ): 

            $the_query->the_post();
             ?>

            
                    <b> <h1><?php the_title(); ?></h1></b>
                    <p style="text-align:center;"><?php the_content(); ?></p>
                    <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail');?></a>
            <li><a href="<?php echo esc_url( post_permalink() ); ?>"><?php the_title();?></a>
            </li>

        <?php endwhile;

        ?>
        
    </div>
   </div>
</div>
<?php

      // echo '<ul>';
        wp_reset_postdata();  
    endif;

    die();
}



 //function demo(){
     //echo "Hi! im maryam";
 //}
// add_shortcode('myshort','demo');
// shortcode code ends here*/
// >>****************************************************************************************************************************************************************************************************************************************************************************** Create Shortcode to Display Movies Post Types******************************
  
function shortcode_movie_post_type()
{
    $curentpage = get_query_var('paged');
    $args = array(
                    'post_type'      => 'recipe',
                    'posts_per_page' => '2',
                    'publish_status' => 'published',
                    'paged' => $curentpage
                 );
  
    $query = new WP_Query($args);
  
    $result = '';
    if($query->have_posts()) :

        while($query->have_posts()) :
  
            $query->the_post();
          
            $result = $result . "<h2>" . get_the_title() . "</h2>";
            $result = $result . get_the_post_thumbnail();
            $result = $result . "<p>" . get_the_content() . "</p>";

        endwhile;
        wp_reset_postdata();
       
        echo paginate_links(array(
            'total' => $query->max_num_pages
        )); 
    endif;   
    return $result;
            
}
  
    add_shortcode( 'recipe-list', 'shortcode_movie_post_type' ); 
  
// shortcode code ends here
  ?>

<!-------------------------------------********************************************************************************************************************************************************************************************************************************************************sorting ajax php ******************************************************************************************************-->





<?php
    /**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * 
 */
function add_custom_taxonomies() {
  // Add new "recipes" taxonomy to Posts
  register_taxonomy('recipe-book', 'recipe', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'recipe-book', 'Spices' ),
      'singular_name' => _x( 'recipe', 'spice-book' ),
      'search_items' =>  __( 'Search recipes' ),
      'all_items' => __( 'All recipes' ),
      'parent_item' => __( 'Parent recipe' ),
      'parent_item_colon' => __( 'Parent recipe:' ),
      'edit_item' => __( 'Edit recipe' ),
      'upoldest_item' => __( 'Upoldest recipe' ),
      'add_new_item' => __( 'Add New recipe' ),
      'new_item_name' => __( 'New recipe Name' ),
      'menu_name' => __( 'Recipe-Book' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'slug', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/recipes/"
      'hierarchical' => true // This will allow URL's like "/recipes/boston/cambridge/"
    ),
  ));
}
   add_action( 'init', 'add_custom_taxonomies', 0 );
//*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************
?>
<!---********************************************************************************************************************************************************************************************************************************************************************************** Drop down in ****************************************************************************************************************---->
