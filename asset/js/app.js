jQuery(document).ready(function(){
  jQuery("#cat").change(function(){
           jQuery("#loaders").show();
          if(jQuery("#cat").val() !=""){
            jQuery("#loaders").show();
           jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                  data:{
                  action: 'rigsters_id',
                  select_cat:jQuery("#cat").val(),
                  subcheck:'true'
                },
                success: function (data) {
                    if(data == "0"){              
                     respone ="هیچ  اطلاعات در مورد  درخواست شما وجود ندارد" ;
                     jQuery(".products").html(`<h4 style="color:red;">`+ respone +`<h4>`);
                   }else{                
                         jQuery("#parent").html(data);  
                 }

                       jQuery("#loaders").hide(); 
                },error:function(error){
                    alert(error);
                    jQuery("#loaders").hide();
                }
            });

            }else{ 
               jQuery("#loaders").hide(); 
               jQuery(".myparent").append('<option value="null">لطفا دسته رو انتخاب نمایید</option>');
    
         }

      });
jQuery("#btn_submit").click(function(){
     if(jQuery("#post_title").val() != "" ||  jQuery("#price").val() !="null" || jQuery("#cat").val() !="null"|| jQuery("#brand").val() !="null"){
           jQuery("#loaders").show();
          jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                  data: {
                  action: 'rigsters_id',
                  subcheck:"true",
                  post_title: jQuery("#post_title").val(),
                  price: jQuery("#price").val(),
                  cat: jQuery("#cat").val(),
                  brand: jQuery("#brand").val(),
                  parent: jQuery("#parent").val(),
                   },
                success: function (data) {
                  if(data == "0"){
                     respone ="هیچ  اطلاعات در مورد  درخواست شما وجود ندارد" ;
                       jQuery(".products").html (`<h4 style="color:red;">`+ respone +`<h4>`);
                      console.log(data);
                   }else{
                      jQuery(".products").html (data );  
                       console.log(data);
                 }   

                jQuery("#loaders").hide();
                },error:function(erroe){

                     alert(erroe);
                     jQuery("#loaders").hide(); 
                }
            });

               }
             else
              {
                jQuery("#loaders").hide();
                    respone ="هیچ  اطلاعات در مورد  درخواست شما وجود ندارد" ;
                       jQuery(".products").html (`<h4 style="color:red;">`+ respone +`<h4>`); 
               
           }

        
        }); 



});///document
