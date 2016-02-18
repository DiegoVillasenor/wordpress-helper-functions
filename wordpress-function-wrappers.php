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

/**
 * Verifica que una algo exista
 * 
 * @param  String, Array, Variable $something    
 * @param  string $returned If something does not exist
 * @return $somthing or $returned           
 */
function init($something, $returned = '') {
	return ( isset($something) ) ? $something : $returned;
}


/**
 * Inicializa un array
 * 
 * @param  array $array el array a inicializar
 * @return array inicializado
 */
function initArray($array, $key, $returned = []) {
	return ( isset($array[$key]) && is_array($array[$key]) ) ? $array[$key] : $returned;
}

/**
 * Inicializa un array anidado en otro array
 * 
 * @param  [type] $array         [description]
 * @param  [type] $sub_array_key [description]
 * @return [type]                [description]
 */
function initSubArray($array, $sub_array_key) {
	return ( is_array($array) && isset($array[$sub_array_key]) && is_array($array[$sub_array_key]) ) ? $array[$sub_array_key] : [];
} 

/**
 * Determines if an attachment is of the specified MIME Type
 * @param  number  $attachment_id 
 * @param  string  $mime_type     
 * @return boolean                False if MIME Type does not match.
 */
function isMimeType($attachment_id, $mime_type) {
	return strpos( get_post_mime_type( $attachment_id ), $mime_type ) !== false;
}

/**
 * Adds class to selected menu item
 * 
 * @param  string $name Slug, custom post type name, or categroy name.
 * @param  string $type Page, single, category, or custom
 * @return string       CSS class
 */
function selectMenuItem($name, $type='page') {
  global $post;
  
  if ($type === 'page') {
    if ( is_page($name) ) {
      return 'menuMain__link--active';
    }
  }

  if ($type === 'custom') {
    if ( is_post_type_archive($name) ) {
      return 'menuMain__link--active';
    }
  }

   if ($type === 'category') {
    if ( is_category($name) ) {
      return 'menuMain__link--active';
    }
  }

  if ($type === 'single') {
    if (is_single() && get_the_category($post->ID)[0]->slug === $name) {
      return 'menuMain__link--active';
    }
  }
}
	





	

