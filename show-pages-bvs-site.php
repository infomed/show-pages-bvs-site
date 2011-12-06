<?php

/*
Plugin Name: show-pages-bvs-site
Description: Muestra las p&aacute;ginas de segundo nivel.
Version: 0.0.1
Author: Ing. Pavel Rivera Abdo
Author Email:   pavel.rivera@infomed.sld.cu 
*/ 


define('SPBS_PLUGIN_URL', plugin_dir_url( __FILE__ ));


function get_custom_post_type_template($single_template) {

    global $wp_query;
    $post = $wp_query->post;
    $sidebars_widgets = get_option('sidebars_widgets', array());
       

    if(!strpos($post->post_type,"vhl_collection"))
    {
     //Aqui elimino todos los widget que estan en el theme excepto el breadcrumd
       foreach ( (array) $sidebars_widgets as $index => $sidebar ) 
        { 
            if ( is_array($sidebar) && $index!="wp_inactive_widgets") 
            {
                //echo "nombre sidebar: ". $index."<br>";
                $name_sidebar="";
                foreach ( $sidebar as $i => $name ) 
                {       
                    //echo "widget: ".$sidebars_widgets[$index][$i]."<br>";
                    if(strpos( $sidebars_widgets[$index][$i], "breadcrumb-navxt" ) === false)
                    {
                        //echo "widget: ".$sidebars_widgets[$index][$i]."<br>";
                        unset($sidebars_widgets[$index][$i]);
                    }         
                }
            }
        }
     
     $GLOBALS['_wp_sidebars_widgets']=$sidebars_widgets;//con esto cambio el valor que esta en memoria 
     $single_template = dirname( __FILE__ ) . '/post-type-template.php'; 
    }
     else
     if($post->post_type=="page")
     {
         $name_sidebar="first-top-widget-area";
         foreach ( (array) $sidebars_widgets as $index => $sidebar ) 
            { 
                if ( is_array($sidebar) && $index!="wp_inactive_widgets") 
                {
                    //echo "nombre sidebar: ". $index."<br>";
                    if($index==$name_sidebar)
                    {
                       foreach ( $sidebar as $i => $name ) 
                        {       
                            //echo "widget: ".$sidebars_widgets[$index][$i]."<br>";
                            unset($sidebars_widgets[$index][$i]);//elimino de la memoria      
                        } 
                    }
                }
            }
            
            //Aqui elimino el widget infobuscadorfacet y el infobuscadorresult 
           foreach ( (array) $sidebars_widgets as $index => $sidebar ) 
            { 
                if ( is_array($sidebar) && $index!="wp_inactive_widgets") 
                {
                    //echo "nombre sidebar: ". $index."<br>";
                    $name_sidebar="";
                    foreach ( $sidebar as $i => $name ) 
                    {       
                        //echo "widget: ".$sidebars_widgets[$index][$i]."<br>";
                        if( strpos( $sidebars_widgets[$index][$i], "infobuscadorfacet" ) !== false || strpos( $sidebars_widgets[$index][$i], "infobuscadorresult" ) !== false )
                         {
                             unset($sidebars_widgets[$index][$i]);                   
                         }      
                    }
                }
            }
            
         $GLOBALS['_wp_sidebars_widgets']=$sidebars_widgets;//con esto cambio el valor que esta en memoria   
     }
     
     $urlcss = SPBS_PLUGIN_URL.'css/style.css';
     echo "<link media='screen' type='text/css' href='$urlcss' rel='stylesheet'/>";
     return $single_template;
}

add_filter( "single_template", "get_custom_post_type_template" ) ;  
  
?>
