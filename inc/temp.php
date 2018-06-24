<?php 
add_action('aws_search_form','aws_search_form');
add_shortcode('aws_search_form','aws_search_form');


 function aws_search_form(){
   global $wpdb;
    wp_register_script('app',RIG_JS_URL.'app.js');
    wp_enqueue_script('app');

    wp_register_style( 'my-app',RIG_css_URL.'app.css');
    wp_enqueue_style( 'my-app' );

      wp_register_style('theme',RIG_css_URL.'bootstrap-theme.min.css');
    wp_enqueue_style('theme');
      wp_register_style('my-bootstrap',RIG_css_URL.'bootstrap.min.css');
    wp_enqueue_style( 'my-bootstrap' );
?>
   <script type="text/javascript"> var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; </script>
    <?php $results = $wpdb->get_results(" 
     SELECT `terms`.`term_id` , `terms`.`name`,`terms_t`.`term_id` ,`terms_t`.`taxonomy`
     FROM  `ss_terms` as `terms`, `ss_term_taxonomy` as `terms_t`WHERE  `terms`.`term_id`= `terms_t`.`term_id` "); ?>


     <form method="post" action="#" accept-charset="UTF-8" class="form_div">
        <div class="col-md-12 col-xs-12 pull-right mycontarin">
            <div class=" panel col-xs-12  mypanel-default ">   
 <label>  جستجو براساس محصولات</label>     
                 <div class="form-group col-md-12">
                     <button id="btn_submit" class="pull-left"  type="button" >
                       <span class="glyphicon glyphicon-search"> </span>
                       </button>
                     <input  id="post_title" name="post_title" class="col-md-11">

                           
                 </div>
                  <div class="form-group col-md-3">
                      <label>براساس زیر دسته</label><br>

                        <select name="parent" class="myparent form-control" id="parent" >
                                                 
                         </select>
               </div>
             
                 <div class="form-group col-md-3">
                      <label>براساس دسته </label><br>
                        <select name="cat" id="cat"  class="form-control">
                                                   <option value="null"> انتخاب فیلتر</option>

                              <?php foreach($results as $product):?>
                              <?php if($product->taxonomy == "product_cat"):?>
                               <option value="<?= $product->term_id ?>"><?= $product->name ?></option>   
                              <?php endif;?>
                            <?php endforeach;?>  
                       </select>
                 </div>
                 <div class="form-group col-md-3">
                   
                     <label>براساس برند </label><br>
               <select name="brand" id="brand" class="form-control">
                                                   <option value="null"> انتخاب فیلتر</option>
                    
  <?php foreach($results as $brand):?>
                          <?php if($brand->taxonomy == "product_brand"):?>
                          <option value="<?= $brand->term_id ?>"><?= $brand->name; ?></option>   
                         <?php endif;?>  
                      <?php endforeach;?>  
              </select>
                 </div>
				                  <div class="form-group col-md-3">
 <label>قیمت محصولات</label><br>
                     <select name="price" id="price" class="form-control">
                                                   <option value="null"> انتخاب فیلتر</option>

                        <option value="asc">بیشرین قیمت </option>
                        <option value="desc"> کمترین قیمت</option>
                     </select>
                 </div> 

            </div>
        </div>   
     </form>

   <div id="loaders" class="loaders col-md-8" hidden >
        <img src="<?= RIG_css_URL?>/ajax-loader-2.gif">
    </div>  

<?php 

}


