<?php  

	include __DIR__."/../../wp-load.php";
    include __DIR__."/../../_includes/functions_global.php";
    include __DIR__."/../../_includes/functions_template_newsletter.php";

    global $wpdb;

    $site_url  = get_option('dashboard_static_html_url_front', '');
    $image_url = get_option('dashboard_static_html_url_image', '');

    $templateNewsletter = new templateNewsletter();
    
    $data = $templateNewsletter->searchData();

    $subscribers = $wpdb->get_results("SELECT name, email FROM ".$wpdb->prefix."subscribers WHERE status = 1");

    $i = 0;

    foreach ($data->posts as $post): 
        $data_index_post = [];     
        $posts_newsletter = get_field('posts_newsletter', $post->ID);   
               
        update_post_meta($post->ID, '_newsletter_status', 1);       

        foreach ($posts_newsletter as $post_newsletter): 
            $data_index_post[] = rtb_return_array_data_post( (object)$post_newsletter, 'medium', $site_url, $image_url ); 
        endforeach; 

        $html = $templateNewsletter->createNewsletter($data_index_post);

        if (isset($html) && !empty($html)):  

            foreach ($subscribers as $subscriber):                 

                $mail    = $subscriber->email; 
                $subject = 'Newsletter Radio ADN';
                $header  = "Content-Type: text/html; charset=UTF-8";
                $content = $html;

                wp_mail($mail, $subject, $content, $header);  
                $wpdb->query("UPDATE ".$wpdb->prefix."subscribers SET last_activity = '".current_time('Y-m-d H:i:s')."' WHERE email = '".$mail."'");               
                $i++;

                echo current_time('Y-m-d H:i:s');
                ?><br><?php                           

                if ($i >= 2):
                    sleep(30);
                    $i = 0;
                endif;

            endforeach;                                  
        
        endif; 
         
        update_post_meta($post->ID, '_newsletter_status', 2);               

    endforeach;


   







    

    







