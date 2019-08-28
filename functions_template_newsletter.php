<?php

/**
* TEMPLATE NEWSLETTER
*/
class templateNewsletter
{

    function __construct(){
    }

    public function searchData(){

        $args = array(
            'post_type'   => 'newsletter', 
            'post_status' => 'publish',     
            'meta_query'  => array(
                array(
                    'key' => 'posts_newsletter',
                ),
                array(
                    'key'     => '_newsletter_status',
                    'compare' => 'NOT EXISTS',
                ),
            )
        );

        $query = new WP_Query( $args );
        $post_newsletter = $query;
        wp_reset_postdata();

        return $post_newsletter;
    }

    public function createNewsletter($data){

        $html    = ''; 
        //$timestamp = current_time('Y-m-d H:i:s');
        ob_start();    
        ?> 

        <h3>Newsletter: <?php the_title(); ?></h3><br>

        <?php foreach ($data as $key => $value): ?>

            <p><?php echo $value['titulo']; ?></p>                
            <p><?php echo $value['fecha']; ?></p>  
            <!-- <div><img src="<?php echo $value['imagen_src']; ?>"></div> -->           
            <p><?php echo $value['contenido']; ?></p>
            <!-- <a href="<?php echo $value['url']; ?>"><?php echo $value['url']; ?></a> -->            

        <?php endforeach; ?>

        <a href="https://www.canalnet.tv/">Cancelar suscripción a newsletter</a>

        <?php             

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}