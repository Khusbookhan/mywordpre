<?php
/**
 * Template Name: Recipe Book
 */
get_header();  

?>
<div class="search_bar">
    <form action="/" method="get" autocomplete="off" style="width: 300px;">
        <input type="text" name="s" placeholder="Search here" id="keyword" class="input_search" onkeyup="fetch()">
        <button style="margin-left:150px;">
            Search
        </button>
    </form>
    <div class="search_result" id="datafetch">
    </div>
</div>
<?php
get_footer();
?>