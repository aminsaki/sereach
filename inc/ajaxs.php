<?php
if($_POST['subcheck']=="true"){
if(!empty($_POST['select_cat'])  ){
$rezat=""; 
$list_parent=[];
$cats=$_POST['select_cat'];
$sql = $wpdb->get_results(" SELECT *  FROM `ss_term_taxonomy`   WHERE `parent` = '$cats'");
foreach($sql as $ro){

    $list_parent[]= $ro->term_id;
}    
$parent =  implode(",", $list_parent);

$sqlrezate = $wpdb->get_results("SELECT * FROM `ss_terms` WHERE `term_id`  IN ($parent); ");
 foreach($sqlrezate  as $rows){

   print("<option value=".$rows->term_id.">".$rows->name." </option>");  
      exit(); 
 }

}

function test($post_title = null , $cat = null , $brand = null , $preand = null , $pices = null){

$term_id_list = [];
    $queryCondition = "  "; 

    if($post_title !="")
      $queryCondition .= " AND `ss_posts`.`post_title` LIKE '%".$post_title."%'";

    if($cat != null && $cat != 'null')
      $term_id_list[] = $cat;

      if($brand != null && $brand != 'null')
      $term_id_list[] = $brand;

    if($preand != null && $preand != 'null')
      $term_id_list[] = $preand;

    if(count($term_id_list) != 0)
      $queryCondition .= " AND `ss_terms`.`term_id` IN (".implode(',', $term_id_list).")";

    if($pices != null  && $pices!= 'null')
      $queryCondition .= " ORDER BY `ss_postmeta`.`meta_value` ".$pices." ;" ;

    return    $queryCondition;       
}

    $post_title = $_POST['post_title'];
    $cat =$_POST['cat'];
    $brand =$_POST['brand'];
    $preand = $_POST['parent'];
    $pices =$_POST['price'];

$where = test($post_title , $cat , $brand , $preand  , $pices);

$rezat = $wpdb->get_results(" SELECT 
       `ss_terms`.`name`,   
       `ss_terms`.`term_id` as `term_id`,
       `ss_term_taxonomy`.`term_id` as `taxonomy_term_id`,
       `ss_term_taxonomy`.`term_taxonomy_id` as `term_taxonomy_id`,
       `ss_term_relationships`.`term_taxonomy_id` as `relationships_term_taxonomy_id`,
       `ss_term_relationships`.`object_id` as `object_id`, 

       `ss_postmeta`.`meta_key`,
       `ss_postmeta`.`meta_value`,
       `ss_postmeta`.`post_id`, 
          `ss_posts`.`post_title`, 
        `ss_posts`.`ID`     

       FROM `ss_terms`,`ss_term_taxonomy`,`ss_term_relationships`,`ss_postmeta`,`ss_posts`    
       WHERE `ss_terms`.`term_id` = `ss_term_taxonomy`.`term_id`
       AND `ss_term_taxonomy`.`term_taxonomy_id` = `ss_term_relationships`.`term_taxonomy_id`              
       AND `ss_term_relationships`.`object_id` = `ss_postmeta`.`post_id`
       AND `ss_postmeta`.`meta_key` = '_price'
       AND `ss_postmeta`.`post_id` = `ss_posts`.`ID`
       ".$where." ;");
   

$upload = wp_upload_dir();
$upload_dir = $upload['baseurl'];
$count = 0;
foreach($rezat  as $row){
$count++;
     $resultss = $wpdb->get_results( "SELECT * FROM `ss_postmeta` 
   WHERE  `post_id` ='$row->ID'
    AND   meta_key ='_thumbnail_id'" );

   foreach($resultss as $rows){
   $resultstow = $wpdb->get_results( "SELECT * FROM `ss_postmeta` 
   WHERE  `post_id` ='$rows->meta_value'
    AND   meta_key ='_wp_attached_file'" );

   foreach($resultstow as $rowt){

         $listtow= $rowt->meta_value;
      }
    
 }

if($count == 5):
 print("
   <li class='first post-".$row->ID." product type-product status-publish has-post-thumbnail ".$row->taxonomy."-".$row->term_id." product_brand-olident  instock shipping-taxable purchasable product-type-simple' >
    <a href='".site_url()."/shop/".sanitize_title_with_dashes($row->post_title)."/' class='woocommerce-LoopProduct-link woocommerce-loop-product__link'>
   </a>
   <a href='".site_url()."/shop/".sanitize_title_with_dashes($row->post_title)."'>
   <img width='262' height='262' src='".$upload_dir.'/'.$listtow. "' class='attachment-shop_catalog  size-shop_catalog wp-post-image' alt='".sanitize_title_with_dashes($row->post_title)." '>' 
  <div class='qodef-woocommerce-product-info-holder'>
    <div class='qodef-woocommerce-product-list-info'>
  <h1 class='qodef-product-list-product-title'>".$row->post_title."</h1>
  <span class='mg-brand-wrapper mg-brand-wrapper-category'>
  <a href='".site_url()."/brands/$row->name'> <b>Brand:</b>".$row->name."</a></span>
    </span><span class='price'><span class='woocommerce-Price-amount amount'>".$row->meta_value."&nbsp;<span class='woocommerce-Price-currencySymbol'>ریال</span></span></span>
</div>

<div class='qodef-woocommerce-product-list-button-holder'>
<div class='qodef-woocommerce-product-list-details-button-holder'>
  <a href='".site_url()."/shop/".sanitize_title_with_dashes($row->post_title)."/' target='_self' class='qodef-btn qodef-btn-medium qodef-btn-default single_view_product_button alt' rel='nofollow'><span class='qodef-btn-text'>جزئیات</span>   
   <span class='qodef-btn-text-icon'></span></a></div>
<div class='qodef-woocommerce-product-list-add-to-cart-button-holder'>


  <a href='".site_url()."/new/?add-to-cart=".$row->ID."' target='_self' class='qodef-btn qodef-btn-medium qodef-btn-default add_to_cart_button product_type_simple' rel='nofollow' data-product_id='".$row->ID."' data-quantity='1'><span class='qodef-btn-text'>اضافه به سبد</span>   
    <span class='qodef-btn-text-icon'></span></a>
    </div></div></div></li></ul>");  

 $count= 1;
else:
  print("
   <li class=' post-".$row->ID." product type-product status-publish has-post-thumbnail ".$row->taxonomy."-".$row->term_id." product_brand-olident  instock shipping-taxable purchasable product-type-simple'>
    <a href='".site_url()."/shop/".sanitize_title_with_dashes($row->post_title)."' class='woocommerce-LoopProduct-link woocommerce-loop-product__link'>
   </a>
   <a href='".site_url()."/shop/نوار-استریپ/'>
   <img width=262' height='262' src='".$upload_dir.'/'.$listtow. "'
    class='attachment-shop_catalog 
     size-shop_catalog wp-post-image' alt='".$row->post_title."' > 


  <div class='qodef-woocommerce-product-info-holder'>
    <div class='qodef-woocommerce-product-list-info'>
  <h1 class='qodef-product-list-product-title'>".$row->post_title."</h1>
  <span class='mg-brand-wrapper mg-brand-wrapper-category'>
  <a href='".site_url()."/brands/$row->name'>  <b>Brand:</b>".$row->name."</a></span>
    </span><span class='price'><span class='woocommerce-Price-amount amount'>".$row->meta_value."&nbsp;<span class='woocommerce-Price-currencySymbol'>ریال</span></span></span>
</div>

<div class='qodef-woocommerce-product-list-button-holder'>
<div class='qodef-woocommerce-product-list-details-button-holder'>
  <a href='".site_url()."/shop/".sanitize_title_with_dashes($row->post_title)."/' 
target='_self' class='qodef-btn qodef-btn-medium qodef-btn-default single_view_product_button alt' rel='nofollow'><span class='qodef-btn-text'>جزئیات</span>   
   <span class='qodef-btn-text-icon'></span></a></div>
<div class='qodef-woocommerce-product-list-add-to-cart-button-holder'>

  <a href='".site_url()."/new/?add-to-cart=".$row->ID."' target='_self' class='qodef-btn qodef-btn-medium qodef-btn-default add_to_cart_button product_type_simple' rel='nofollow' data-product_id='".$row->ID."' data-quantity='1'><span class='qodef-btn-text'>اضافه به سبد</span>   
    <span class='qodef-btn-text-icon'></span></a>
    </div></div></div></li></ul>");      

endif;///count

}


  
exit();
}









