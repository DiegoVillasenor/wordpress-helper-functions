<?php

/**
 * Regresa solo la parte del texto del idioma correpondiete
 * 
 * @param  string $text cadena de texto que ontiene los idiomas
 * @param  string $lang idioma al que se le va a traducir (por defecto  qtranxf_getLanguage() )
 * @return string  cadena con el texto en el idioma
 */
function cltvo_translate($text, $lang = "" ){
    if ( empty($lang) ) {
        $lang = qtranxf_getLanguage() ;
    }
    return qtranxf_use($lang , $text , false, true);
}

function cltvo_siteTitle()
{
	echo get_bloginfo( 'name' );
	
}

function cltvo_siteDescription()
{
	echo get_bloginfo( 'description' );
}

function cltvo_title($post, $translate=false)
{
	if ($translate == true) {
		return cltvo_translate($post->post_title);
	}
	 return $post->post_title;
}

function cltvo_content($post, $translate=false, $filters=false)
{
	if ($translate==false && $filters==false)
	{
		return wpautop($post->post_content);
	}
	elseif ($translate==false && $filters==true) {
		return apply_filters('the_content', $post->post_content);
	}
	elseif ($translate==true && $filters==false) {
		return cltvo_translate( wpautop($post->post_content) );
	}
	elseif ($translate==true && $filters==true) {
		return cltvo_translate(apply_filters('the_content', $post->post_content) );
	}

}




function cltvo_slug($post)
{
	 echo $post->post_name;
}



/**
 * Easily includes files within the theme directory
 * 
 * @param  string  	$path 	path to the image from theme directory
 * @return string  			full path
 */
function themeInc($path, $global_post=true)
{
	if ($global_post) {
		global $post;
	}
	include ( get_stylesheet_directory() . $path );
}



/**
 * Easily includes files withing the theme directory
 * 
 * @param  string  	$path 	path to the image from theme directory
 * @return string  			full path
 */
function echoImg($img_name)
{
	echo ( get_stylesheet_directory_uri().'/images/'.$img_name );
}



/**
 * Get Page ID from Page Slug
 * @param  string $page_slug      	Slug
 * @param  string $slug_page_type 	Post Type
 * @return string                	ID
 */
function get_id_by_slug($page_slug, $slug_page_type = 'page') 
{
	$found_page = get_page_by_path($page_slug, OBJECT, $slug_page_type);
	
	if ( ! $found_page) {
		return null;
	}
	return $found_page->ID;
}


/**
 * Get Page by from Page Slug
 * @param  string $page_slug      	Slug
 * @param  string $slug_page_type 	Post Type
 * @return string                	ID
 */
function getPageFromSlug($page_slug, $slug_page_type = 'page') 
{
	$found_page = get_page_by_path($page_slug, OBJECT, $slug_page_type);
	
	if ( ! $found_page) {
		return null;
	}
	return $found_page;
}



/**
 * Echo Page Content from Page Slug (with wpautop)
 * @param  string $page_slug      	Slug
 * @param  string $slug_page_type 	Post Type
 * @return string                	ID
 */
function echoPageContent($page_slug, $slug_page_type = 'page')
{
	$page = get_page_by_path($page_slug, OBJECT, $slug_page_type);
	echo wpautop($page->post_content);

}

/**
 * Echo Page Title from Page Slug
 * @param  string $page_slug      	Slug
 * @param  string $slug_page_type 	Post Type
 * @return string                	ID
 */
function echoPageTitle($page_slug, $slug_page_type = 'page')
{
	$page = get_page_by_path($page_slug, OBJECT, $slug_page_type);
	echo $page->post_title;
}


// function queryChildren($parent_slug, $default_args = true , $query_args = [] ){
// 	$cltvo_wp_query = new WP_Query();

// 	if (true == $default_args) 
// 	{
// 		$queried_pages = $cltvo_wp_query->query(array('post_type' => 'page'));
// 		return get_page_children( get_id_by_slug($parent_slug), $queried_pages );
// 	}
	
// 	$queried_pages = $cltvo_wp_query->query($query_args));
// 	return get_page_children( get_id_by_slug($parent_slug), $queried_pages )
// }

function queryChildrenBySlug( $parent_slug, $default_args = true , $query_args = [] ){
	$cltvo_wp_query = new WP_Query();
	
	if (true == $default_args)
	{
		$queried_pages = $cltvo_wp_query->query(array('post_type' => 'page'));
		return get_page_children( get_id_by_slug($parent_slug), $queried_pages );
	}

	$queried_pages = $cltvo_wp_query->query($query_args);
	return get_page_children( get_id_by_slug($parent_slug), $queried_pages );

}

function queryChildren( $post, $default_args = true , $query_args = [] ){
	$cltvo_wp_query = new WP_Query();
	
	if (true == $default_args)
	{
		$queried_pages = $cltvo_wp_query->query(array('post_type' => 'page'));
		return get_page_children( $post->ID, $queried_pages );
	}

	$query = $cltvo_wp_query->query($query_args);
	return get_page_children( $post->ID, $query );

}







	

