<?php
/**
* Setup blog pagination function
**/
function grandtour_pagination($pages = '', $range = 4)
{
	 $showitems = ($range * 2)+1;
	 
	 $paged = grandtour_get_paged();
	 if(empty($paged)) $paged = 1;
	 
	 if($pages == '')
	 {
	 $wp_query = grandtour_get_wp_query();
	 $pages = $wp_query->max_num_pages;
	 if(!$pages)
	 {
	 $pages = 1;
	 }
	 }
	 
	 if(1 != $pages)
	 {
	 echo "<div class=\"pagination\">";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
	 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
	 
	 for ($i=1; $i <= $pages; $i++)
	 {
	 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	 {
	 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
	 }
	 }
	 
	 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
	 echo "</div>";
	 }
}

function grandtour_get_review($post_id = '', $rating_field = '')
{
	$rating_arr = array();
	if(!empty($post_id) && !empty($rating_field))
	{
		$args = array(
			'status' => 'approve',
			'post_id' => $post_id, // use post_id, not post_ID
		);
		$comments = get_comments($args);
		$count_comments = count($comments);
		$rating_avg = 0;
		$rating_points = 0;
		
		if(!empty($comments) && is_array($comments))
		{
			foreach($comments as $comment)
			{
				$rating = get_comment_meta( $comment->comment_ID, $rating_field, true );
				
				if(!is_numeric($rating))
				{
					$rating = 0;
				}
				
				$rating_points += $rating;
			}
			
			$rating_avg = $rating_points/$count_comments;
		}
		
		$rating_arr = array(
			'average'	=> $rating_avg,
			'points'	=> $rating_points,
			'count'		=> $count_comments,
		);
		
		return $rating_arr;
	}
	else
	{
		return $rating_arr = array(
			'average'	=> 0,
			'points'	=> 0,
			'count'		=> 0,
		);
	}
}
    
/**
*	Setup comment style
**/
function grandtour_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; 
?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<?php
		$has_avatar = get_avatar($comment,$size='60',$default='' );
		
		if($has_avatar != '')
		{
		?>
		<div class="gravatar">
         	<?php echo get_avatar($comment,$size='60',$default='' ); ?>
      	</div>
      	<?php
      	}
      	?>
      
      	<div class="right <?php if($has_avatar == '') { ?>fullwidth<?php } ?>">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php echo esc_html_e('(Your comment is awaiting moderation.)', 'grandtour') ?></em>
         		<br />
      		<?php endif; ?>
			
			<?php
				if(!empty($comment->comment_author_url))
				{
			?>
					<a href="<?php echo esc_url($comment->comment_author_url); ?>"><h7><?php echo esc_html($comment->comment_author); ?></h7></a>
			<?php
				}
				else
				{
			?>
					<h7><?php echo esc_html($comment->comment_author); ?></h7>
			<?php
				}
			?>
			
			<div class="comment_date"><?php echo date_i18n(GRANDTOUR_THEMEDATEFORMAT, strtotime($comment->comment_date)); ?> <?php echo esc_html_e('at', 'grandtour') ?> <?php echo date_i18n(GRANDTOUR_THEMETIMEFORMAT, strtotime($comment->comment_date)); ?></div>
			<?php 
      			if($depth < 3)
      			{
      		?>
      			<?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' =>  __('Reply', 'grandtour'), 'login_text' => __('Login to Reply', 'grandtour'), 'max_depth' => $args['max_depth']))) ?>
			<?php
				}
			?>
			<div class="comment_text"/>
      			<?php ' '.comment_text() ?>
	  		</div>
      	</div>
    </div>
    <?php 
        if($depth == 1)
        {
    ?>
    <br class="clear"/>
    <?php
    	}
    ?>
<?php
}

// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function grandtour_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function grandtour_posts($sort = 'recent', $items = 3, $echo = TRUE, $show_thumb = TRUE) 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$args = array(
			'numberposts' => $items,
			'order' => 'DESC',
			'orderby' => 'date',
			'post_type' => 'post',
			'post_status' => 'publish',
			'suppress_filters' => 0,
		);
		$posts = get_posts($args);
		$title = esc_html__('Recent Posts', 'grandtour');
	}
	
	if(!empty($posts))
	{
		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="posts blog ';
		
		if($show_thumb)
		{
			$return_html.= 'withthumb ';
		}
		
		$return_html.= '">';
		
		$count_post = count($posts);

			foreach($posts as $post)
			{
				$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
				$return_html.= '<li>';
				
				if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'"><img src="'.$image_url[0].'" alt="" /></a></div>';
				}
				
				$return_html.= '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a><div class="post_attribute">'.date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U', $post->ID)).'</div>';
				$return_html.= '</li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo stripslashes($return_html);
	}
	else
	{
		return $return_html;
	}
}

function grandtour_cat_posts($cat_id = '', $items = 5, $echo = TRUE, $show_thumb = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="posts blog ';
		
		if($show_thumb)
		{
			$return_html.= 'withthumb ';
		}
		
		$return_html.= '">';

			foreach($posts as $key => $post)
			{
				$return_html.= '<li>';
			
				if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'"><img class="alignleft frame post_thumb" src="'.$image_url[0].'" alt="" /></a></div>';
				}
				
				$return_html.= '<a href="'.get_permalink($post->ID).'">'.grandtour_substr($post->post_title, 50).'</a><div class="post_attribute">'.date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U', $post->ID)).'</div>';
				$return_html.= '</li>';
			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo stripslashes($return_html);
	}
	else
	{
		return $return_html;
	}
}

function grandtour_image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}


function grandtour_select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_q.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}

function grandtour_get_flickr($settings) 
{
	if (!function_exists('MagpieRSS')) {
	    // Check if another plugin is using RSS, may not work
	    require_once ABSPATH . WPINC . '/class-simplepie.php';
	}
	
	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}
	
	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'https://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'https://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'https://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'https://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'https://api.flickr.com/services/feeds/photos_public.gne?tags=' . $settings['tags'] . '&format=rss_200'; }
	else {
	    print '<strong>No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.</strong>';
	    die();
	}
	
	$flickr_cache_path = GRANDTOUR_THEMEUPLOAD.'/flickr_'.$settings['id'].'_'.$settings['items'].'.cache';
		
	if(file_exists($flickr_cache_path))
	{
	    $flickr_cache_timer = intval((time()-filemtime($flickr_cache_path))/60);
	}
	else
	{
	    $flickr_cache_timer = 0;
	}
	
	$photos_arr = array();
	
	if(!file_exists($flickr_cache_path) OR $flickr_cache_timer > 15)
	{
		# get rss file
		$feed = new SimplePie();
		$feed->set_feed_url($rss_url);
		$feed->enable_cache(FALSE);
		$feed->init();
		$feed->handle_content_type();
		
		foreach ($feed->get_items() as $key => $item)
		{
			$enclosure = $item->get_enclosure();
			$img = grandtour_image_from_description($item->get_description()); 
			$thumb_url = grandtour_select_image($img, 1);
			$large_url = grandtour_select_image($img, 4);
			
			$photos_arr[] = array(
				'title' => $enclosure->get_title(),
				'thumb_url' => $thumb_url,
				'url' => $large_url,
				'link' => $item->get_link(),
			);
			
			$current = intval($key+1);
			
			if($current == $settings['items'])
			{
				break;
			}
		} 
		
		if(!empty($photos_arr))
		{
			if(file_exists($flickr_cache_path))
			{
			    unlink($flickr_cache_path);
			}
			
			//Writing cache file
			$wp_filesystem = grandtour_get_wp_filesystem();
			$wp_filesystem->put_contents(
			  $flickr_cache_path,
			  serialize($photos_arr),
			  FS_CHMOD_FILE
			);
		}
	}
	else
	{
		$wp_filesystem = grandtour_get_wp_filesystem();
		$file = $wp_filesystem->get_contents($flickr_cache_path);
					
		if(!empty($file))
		{
		    $photos_arr = unserialize($file);			
		}
	}

	return $photos_arr;
}

function grandtour_get_instagram($username, $access_token, $items = 8)
{   
	$wp_filesystem = grandtour_get_wp_filesystem();
	
	$photos_arr = array();

    if(!empty($username) && !empty($access_token))
    {
	    $instagram_cache_path = GRANDTOUR_THEMEUPLOAD.'/instagram_'.$username.'_'.$items.'.cache';
		
		if(file_exists($instagram_cache_path))
		{
		    $instagram_cache_timer = intval((time()-filemtime($instagram_cache_path))/60);
		}
		else
		{
		    $instagram_cache_timer = 0;
		}
		
		$photos_arr = array();
		
		if(!file_exists($instagram_cache_path) OR $instagram_cache_timer > 15)
		{
			require_once get_template_directory() . "/modules/instagram/instagram.php";
    
		    $isg = new instagramPhp($username, $access_token); 
		    if(!GRANDTOUR_THEMEDEMO)
		    {
		    	$shots = $isg->getUserMedia(array('count'=> $items)); 
		    }
		    else
		    {
		    	$shots = $isg->getTagMedia(array('count'=> $items), GRANDTOUR_THEMEDEMOIG); 
		    }
		
			if(is_array($shots->data))
			{
				foreach ($shots->data as $key => $item)
				{
					$thumb_url = $item->images->thumbnail->url;
					$large_url = $item->images->standard_resolution->url;
					
					$photos_arr[] = array(
						'thumb_url' => $thumb_url,
						'url' => $large_url,
						'link' => $item->link,
					);
				} 
			}
			
			if(!empty($photos_arr))
			{
				if(file_exists($instagram_cache_path))
				{
				    unlink($instagram_cache_path);
				}
				
				//Writing cache file
				$wp_filesystem->put_contents(
				  $instagram_cache_path,
				  serialize($photos_arr),
				  FS_CHMOD_FILE
				);
			}
			else
			{
				$file = $wp_filesystem->get_contents($instagram_cache_path);
						
				if(!empty($file))
				{
				    $photos_arr = unserialize($file);			
				}
			}
		}
		else
		{
			$file = $wp_filesystem->get_contents($instagram_cache_path);
						
			if(!empty($file))
			{
			    $photos_arr = unserialize($file);			
			}
		}
    } 
    else 
    {
    	echo 'Invalid username and access token';
    }
    
    return $photos_arr;
}

function grandtour_get_browser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    }
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    }
    else
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    }
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    
    // see how many we have
    if(isset($matches['browser']))
    {
    	$i = count($matches['browser']);
    }
    else
    {
	    $i = 0;
	    $matches['version'] = 1;
    }
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        elseif(isset($matches['version'][1])) {
            $version= $matches['version'][1];
        }
        else
        {
	        $version = 11;
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function grandtour_auto_link_twitter($tweet)
{
    //Convert urls to <a> links
	$tweet = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $tweet);

	//Convert hashtags to twitter searches in <a> links
	$tweet = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a target=\"_new\" href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweet);

	//Convert attags to twitter profiles in <a> links
	$tweet = preg_replace("/@([A-Za-z0-9\/\.]*)/", "<a href=\"http://www.twitter.com/$1\">@$1</a>", $tweet);

	return $tweet;
}

function grandtour_resort_gallery_img($all_photo_arr)
{
	$sorted_all_photo_arr = array();
	$tg_gallery_sort = kirki_get_option('tg_gallery_sort');

	if(!empty($tg_gallery_sort) && !empty($all_photo_arr))
	{
		switch($tg_gallery_sort)
		{
			case 'drag':
			default:
				foreach($all_photo_arr as $key => $gallery_img)
				{
					$sorted_all_photo_arr[$key] = $gallery_img;
				}
			break;
			case 'post_date':
				foreach($all_photo_arr as $key => $gallery_img)
				{
					$gallery_img_meta = get_post($gallery_img);
					$gallery_img_date = strtotime($gallery_img_meta->post_date);
					
					$sorted_all_photo_arr[$gallery_img_date] = $gallery_img;
					krsort($sorted_all_photo_arr);
				}
			break;
			
			case 'post_date_old':
				foreach($all_photo_arr as $key => $gallery_img)
				{
					$gallery_img_meta = get_post($gallery_img);
					$gallery_img_date = strtotime($gallery_img_meta->post_date);
					
					$sorted_all_photo_arr[$gallery_img_date] = $gallery_img;
					ksort($sorted_all_photo_arr);
				}
			break;
			
			case 'rand':
				shuffle($all_photo_arr);
				$sorted_all_photo_arr = $all_photo_arr;
			break;
			
			case 'title':
				foreach($all_photo_arr as $key => $gallery_img)
				{
					$gallery_img_meta = get_post($gallery_img);
					$gallery_img_title = $gallery_img_meta->post_title;
					if(empty($gallery_img_title) OR is_null($gallery_img_title))
					{
						$gallery_img_title = $gallery_img_meta->ID;
					}
					
					if(!isset($sorted_all_photo_arr[$gallery_img_title]))
					{
						$sorted_all_photo_arr[$gallery_img_title] = $gallery_img;	
					}
					else
					{
						$sorted_all_photo_arr[$gallery_img_title.$gallery_img_meta->ID] = $gallery_img;
					}
					
					ksort($sorted_all_photo_arr);
				}
			break;
		}
		
		return $sorted_all_photo_arr;
	}
	else
	{
		return array();
	}
}

function grandtour_apply_content($pp_content) {
	$pp_content = apply_filters('the_content', $pp_content);
    $pp_content = str_replace(']]>', ']]>', $pp_content);
    
    return $pp_content;
}

function grandtour_apply_builder($page_id, $post_type = 'page', $print = TRUE) 
{
	$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
	$ppb_page_content = '';
	
	if(isset($ppb_form_data_order[0]))
	{
	    $ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
	}
	
	$ppb_shortcodes = array();
	
	require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
	
	if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	{
	    $ppb_shortcode_code = '';
	
	    foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    {
	    	$ppb_form_item_data = get_post_meta($page_id, $ppb_form_item.'_data');
	    	$ppb_form_item_size = get_post_meta($page_id, $ppb_form_item.'_size');
	    	$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
	    	$ppb_shortcode_content_name = $ppb_form_item_data_obj->shortcode.'_content';
	    	
	    	if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
	    	{
	    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
	    		
	    		//Get shortcode title
	    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	    		{
	    			$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	    		}
	    		
	    		//Get shortcode attributes
	    		if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	    		{
		    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
		    		
		    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
		    		{
		    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
		    			
		    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
		    			{
		    				if(!is_array($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
		    				{
		    					$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
		    				}
		    				else
		    				{
		    					$shortcode_attr_val_str = '';
		    					$i = 0;
		    					$len = count($ppb_form_item_data_obj->$ppb_shortcode_attr_name);
		    					
			    				foreach($ppb_form_item_data_obj->$ppb_shortcode_attr_name as $key => $shortcode_attr_val)
			    				{
				    				$shortcode_attr_val_str.= $shortcode_attr_val;
				    				
				    				if ($i != $len - 1) 
				    				{
				    					$shortcode_attr_val_str.= ',';
				    				}
				    				
				    				$i++;
			    				}
			    				
			    				$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($shortcode_attr_val_str)).'" ';
		    				}
		    			}
		    			elseif($attr_name == 'margin')
		    			{
		    				$ppb_shortcode_attr_margin_top = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_top';
		    				
		    				if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top))
							{
			    				$ppb_shortcode_code.= $attr_name.'_top="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_right = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_right';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right))
							{
			    				$ppb_shortcode_code.= $attr_name.'_right="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_bottom = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_bottom';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom))
							{
			    				$ppb_shortcode_code.= $attr_name.'_bottom="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_left = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_left';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left))
							{
			    				$ppb_shortcode_code.= $attr_name.'_left="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left)).'" ';
			    			}
		    			}
		    		}
		    	}

	    		$ppb_shortcode_code.= ']'.rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
	    	}
	    	else if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	    	{
	    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
	    		
	    		//Get shortcode title
	    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	    		{
	    			$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	    		}
	    		
	    		//Get shortcode attributes
	    		if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	    		{
		    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
		    		
		    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
		    		{
		    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
		    			
		    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
		    			{
		    				if(!is_array($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
		    				{
		    					$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
		    				}
		    				else
		    				{
		    					$shortcode_attr_val_str = '';
		    					$i = 0;
		    					$len = count($ppb_form_item_data_obj->$ppb_shortcode_attr_name);
		    					
			    				foreach($ppb_form_item_data_obj->$ppb_shortcode_attr_name as $key => $shortcode_attr_val)
			    				{
				    				$shortcode_attr_val_str.= $shortcode_attr_val;
				    				
				    				if ($i != $len - 1) 
				    				{
				    					$shortcode_attr_val_str.= ',';
				    				}
				    				
				    				$i++;
			    				}
			    				
			    				$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($shortcode_attr_val_str)).'" ';
		    				}
		    			}
		    			elseif($attr_name == 'margin')
		    			{
		    				$ppb_shortcode_attr_margin_top = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_top';
		    				
		    				if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top))
							{
			    				$ppb_shortcode_code.= $attr_name.'_top="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_right = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_right';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right))
							{
			    				$ppb_shortcode_code.= $attr_name.'_right="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_bottom = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_bottom';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom))
							{
			    				$ppb_shortcode_code.= $attr_name.'_bottom="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom)).'" ';
			    			}
			    			
			    			$ppb_shortcode_attr_margin_left = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_left';
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left))
							{
			    				$ppb_shortcode_code.= $attr_name.'_left="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left)).'" ';
			    			}
		    			}
		    		}
		    	}
	    		
	    		$ppb_shortcode_code.= ']';
	    	}
	    	
	    	if($print)
	    	{
	    		echo grandtour_apply_content($ppb_shortcode_code);
	    	}
	    	else
	    	{
		    	$ppb_page_content.= grandtour_apply_content($ppb_shortcode_code);
	    	}
        }
    }

    if(!$print)
    {
    	return $ppb_page_content;
    }
    	
}

function grandtour_get_excerpt_by_id($post_id)
{
	$the_post = get_post($post_id); //Gets post ID
	if(!empty($the_post->post_excerpt))
	{
		$the_excerpt = $the_post->post_excerpt;
	}
	else
	{
		$the_excerpt = $the_post->post_content;
	}
	
	$excerpt_length = 35; //Sets excerpt length by word count
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
	array_pop($words);
	array_push($words, '…');
	$the_excerpt = implode(' ', $words);
	endif;
	$the_excerpt = '<p>' . $the_excerpt . '</p>';
	return $the_excerpt;
}

function grandtour_get_image_id($url) 
{
	$attachment_id = attachment_url_to_postid($url);
	return $attachment_id;
}

function grandtour_aasort(&$array, $key) 
{
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

if(!function_exists('get_dynamic_sidebar'))
{
	function get_dynamic_sidebar($index = 1)
	{
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}

function grandtour_update_urls($options,$oldurl,$newurl)
{	
	$wpdb = grandtour_get_wpdb();
	$results = array();
	$queries = array(
	'content' =>		array("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)",  esc_html__('Content Items (Posts, Pages, Custom Post Types, Revisions)','grandtour') ),
	'excerpts' =>		array("UPDATE $wpdb->posts SET post_excerpt = replace(post_excerpt, %s, %s)", esc_html__('Excerpts','grandtour') ),
	'attachments' =>	array("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s) WHERE post_type = 'attachment'",  esc_html__('Attachments','grandtour') ),
	'links' =>			array("UPDATE $wpdb->links SET link_url = replace(link_url, %s, %s)", esc_html__('Links','grandtour') ),
	'custom' =>			array("UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s)",  esc_html__('Custom Fields','grandtour') ),
	'guids' =>			array("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)",  esc_html__('GUIDs','grandtour') )
	);

	foreach($options as $option){
	    if( $option == 'custom' ){
	    	$n = 0;
	    	$row_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->postmeta" );
	    	$page_size = 10000;
	    	$pages = ceil( $row_count / $page_size );
	    	
	    	for( $page = 0; $page < $pages; $page++ ) {
	    		$current_row = 0;
	    		$start = $page * $page_size;
	    		$end = $start + $page_size;
	    		$pmquery = "SELECT * FROM $wpdb->postmeta WHERE meta_value <> ''";
	    		$items = $wpdb->get_results( $pmquery );
	    		foreach( $items as $item ){
	    		$value = $item->meta_value;
	    		if( trim($value) == '' )
	    			continue;
	    		
	    			$edited = grandtour_unserialize_replace( $oldurl, $newurl, $value );
	    		
	    			if( $edited != $value ){
	    				$fix = $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = %s WHERE meta_id = %s", $edited, $item->meta_id) );
	    				if( $fix )
	    					$n++;
	    			}
	    		}
	    	}
	    	$results[$option] = array($n, $queries[$option][1]);
	    }
	    else{
	    	$result = $wpdb->query( $wpdb->prepare( $queries[$option][0], $oldurl, $newurl) );
	    	$results[$option] = array($result, $queries[$option][1]);
	    }
	}
	return $results;			
}


function grandtour_unserialize_replace( $from = '', $to = '', $data = '', $serialised = false ) 
{
    try {
    	if ( is_string( $data ) && ( $unserialized = @unserialize( $data ) ) !== false ) {
    		$data = grandtour_unserialize_replace( $from, $to, $unserialized, true );
    	}
    	elseif ( is_array( $data ) ) {
    		$_tmp = array( );
    		foreach ( $data as $key => $value ) {
    			$_tmp[ $key ] = grandtour_unserialize_replace( $from, $to, $value, false );
    		}
    		$data = $_tmp;
    		unset( $_tmp );
    	}
    	else {
    		if ( is_string( $data ) )
    			$data = str_replace( $from, $to, $data );
    	}
    	if ( $serialised )
    		return serialize( $data );
    } catch( Exception $error ) {
    }
    return $data;
}

function grandtour_get_first_title_word($title) {
	return $title;
}

function grandtour_menu_layout() {
	$tg_menu_layout = kirki_get_option('tg_menu_layout');
	if(GRANDTOUR_THEMEDEMO && isset($_GET['menulayout']) && !empty($_GET['menulayout']))
	{
		$tg_menu_layout = $_GET['menulayout'];
	}
	
	return $tg_menu_layout;
}

/**
* grandtour_is_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function grandtour_is_woocommerce_page() 
{
	if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
	        return true;
	}
	$woocommerce_keys   =   array ( "woocommerce_shop_page_id") ;
	foreach ( $woocommerce_keys as $wc_page_id ) {
	        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
	                return true ;
	        }
	}
	return false;
}

function grandtour_check_system()
{
	$has_error = 0;
	$return_html = '<div class="tg_system_status_wrapper">';
	
	$return_html.= '<h4>System Status</h4><br/>';

	//Get max_execution_time
	$max_execution_time = ini_get('max_execution_time');
	$max_execution_time_class = '';
	$max_execution_time_text = '';
	if($max_execution_time < 180)
	{
		$max_execution_time_class = 'tg_error';
		$has_error = 1;
		$max_execution_time_text = '*RECOMMENDED 180';
	}
	$return_html.= '<div class="'.$max_execution_time_class.'">max_execution_time: '.$max_execution_time.' '.$max_execution_time_text.'</div>';
	
	//Get memory_limit
	$memory_limit = ini_get('memory_limit');
	$memory_limit_class = '';
	$memory_limit_text = '';
	if(intval($memory_limit) < 128)
	{
		$memory_limit_class = 'tg_error';
		$has_error = 1;
		$memory_limit_text = '*RECOMMENDED 128M';
	}
	$return_html.= '<div class="'.$memory_limit_class.'">memory_limit: '.$memory_limit.' '.$memory_limit_text.'</div>';
	
	//Get post_max_size
	$post_max_size = ini_get('post_max_size');
	$post_max_size_class = '';
	$post_max_size_text = '';
	if(intval($post_max_size) < 32)
	{
		$post_max_size_class = 'tg_error';
		$has_error = 1;
		$post_max_size_text = '*RECOMMENDED 32M';
	}
	$return_html.= '<div class="'.$post_max_size_class.'">post_max_size: '.$post_max_size.' '.$post_max_size_text.'</div>';
	
	//Get upload_max_filesize
	$upload_max_filesize = ini_get('upload_max_filesize');
	$upload_max_filesize_class = '';
	$upload_max_filesize_text = '';
	if(intval($upload_max_filesize) < 32)
	{
		$upload_max_filesize_class = 'tg_error';
		$has_error = 1;
		$upload_max_filesize_text = '*RECOMMENDED 32M';
	}
	$return_html.= '<div class="'.$upload_max_filesize_class.'">upload_max_filesize: '.$upload_max_filesize.' '.$upload_max_filesize_text.'</div>';
	
	//Get max_input_vars
	$max_input_vars = ini_get('max_input_vars');
	$max_input_vars_class = '';
	$max_input_vars_text = '';
	if(intval($max_input_vars) < 2000)
	{
		$max_input_vars_class = 'tg_error';
		$has_error = 1;
		$max_input_vars_text = '*RECOMMENDED 2000';
	}
	$return_html.= '<div class="'.$max_input_vars_class.'">max_input_vars: '.$max_input_vars.' '.$max_input_vars_text.'</div>';
	
	if(!empty($has_error))
	{
		$return_html.= '<br/><hr/>We are sorry, the demo data could not import properly. It most likely due to PHP configurations on your server. Please fix configuration in System Status which are reported in <span class="tg_error">RED</span>';
	}
	
	$return_html.= '</div>' ;
	
	return $return_html;
}

function grandtour_hex_darker($hex,$factor = 30)
{
    $new_hex = '';
    
    $base['R'] = hexdec($hex{0}.$hex{1});
    $base['G'] = hexdec($hex{2}.$hex{3});
    $base['B'] = hexdec($hex{4}.$hex{5});
    
    foreach ($base as $k => $v)
            {
            $amount = $v / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v - $amount;
    
            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
                    { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
            }
            
    return $new_hex;        
}

function grandtour_get_dynamic_sidebar($index = 1)
{
    $sidebar_contents = "";
    ob_start();
    dynamic_sidebar($index);
    $sidebar_contents = ob_get_clean();
    return $sidebar_contents;
}

function grandtour_hex_to_rgb($hex) 
{
	$hex = str_replace("#", "", $hex);
	$color = array();
	
	if(strlen($hex) == 3) {
	    $color['r'] = hexdec(substr($hex, 0, 1) . $r);
	    $color['g'] = hexdec(substr($hex, 1, 1) . $g);
	    $color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
	    $color['r'] = hexdec(substr($hex, 0, 2));
	    $color['g'] = hexdec(substr($hex, 2, 2));
	    $color['b'] = hexdec(substr($hex, 4, 2));
	}
	
	return $color;
}

function grandtour_available_widgets() 
{
	$wp_registered_widget_controls = grandtour_get_registered_widget_controls();

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

		}

	}

	return $available_widgets;
}

function grandtour_import_data( $data ) 
{
	$wp_registered_sidebars = grandtour_get_registered_sidebars();

	// Have valid data?
	// If no data or could not decode
	if ( empty( $data ) || ! is_object( $data ) ) {
		wp_die(
			esc_html__('Import data could not be read. Please try a different file.', 'grandtour' ),
			'',
			array( 'back_link' => true )
		);
	}

	// Get all available widgets site supports
	$available_widgets = grandtour_available_widgets();

	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}

	// Begin results
	$results = array();

	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {

		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}

		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			$sidebar_available = true;
			$use_sidebar_id = $sidebar_id;
			$sidebar_message_type = 'success';
			$sidebar_message = '';
		} else {
			$sidebar_available = false;
			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			$sidebar_message_type = 'error';
			$sidebar_message = esc_html__('Sidebar does not exist in theme (using Inactive)', 'grandtour' );
		}

		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {

			$fail = false;

			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = esc_html__('Site does not support widget', 'grandtour' ); // explain why widget not imported
			}

			// Filter to modify settings object before conversion to array and import
			// Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
			// Ideally the newer wie_widget_settings_array below will be used instead of this
			$widget = apply_filters( 'wie_widget_settings', $widget ); // object

			// Convert multidimensional objects to multidimensional arrays
			// Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
			// Without this, they are imported as objects and cause fatal error on Widgets page
			// If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
			// It is probably much more likely that arrays are used than objects, however
			$widget = json_decode( json_encode( $widget ), true );

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {

					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = esc_html__('Widget already exists', 'grandtour' ); // explain why widget not imported

						break;

					}

				}

			}

			// No failure
			if ( ! $fail ) {

				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = esc_html__('Imported', 'grandtour' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = esc_html__('Imported to Inactive', 'grandtour' );
				}

			}

			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget['title'] ) ? $widget['title'] : esc_html__('No Title', 'grandtour' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		}

	}

	// Return results
	return $results;
}

function grandtour_count_client_images($client_id = '')
{
	if(!empty($client_id))
	{
		$images_counter = 0;
		$client_galleries = get_post_meta($client_id, 'client_galleries', true);
		
		if(is_array($client_galleries) && !empty($client_galleries))
		{
			foreach($client_galleries as $gallery_id)
			{
				$all_photo_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
				$images_counter += intval(count($all_photo_arr));
			}
		}
		
		return intval($images_counter);
	}
	else
	{
		return 0;
	}
}

function grandtour_set_map_api()
{
	//Get Google Map API Key
	$pp_googlemap_api_key = get_option('pp_googlemap_api_key');
	
	if(empty($pp_googlemap_api_key))
	{
		wp_enqueue_script("google_maps", "https://maps.googleapis.com/maps/api/js", false, GRANDTOUR_THEMEVERSION, true);
	}
	else
	{
		wp_enqueue_script("google_maps", "https://maps.googleapis.com/maps/api/js?key=".$pp_googlemap_api_key, false, GRANDTOUR_THEMEVERSION, true);
	}
}

function grandtour_live_builder_begin_wrapper($item_id = '', $item_type = '')
{
	//Check if live content builder mode
	if(isset($_GET['ppb_live']) && !empty($item_id))
	{
		$return_html = '<div id="live_'.esc_attr($item_id).'" class="ppb_live_edit_wrapper '.esc_attr($item_type).'">';
		$return_html.= '<div class="ppb_live_action">';
		
		if(empty($item_type) OR $item_type != 'ppb_divider')
		{
			$return_html.= '<a href="javascript:;" class="ppb_add_after" data-builder-id="'.esc_attr($item_id).'" title="'.esc_html__('Add Content After This', 'grandtour' ).'"><i class="fa fa-plus"></i></a>';
		
			$return_html.= '<a href="javascript:;" class="ppb_edit" data-builder-id="'.esc_attr($item_id).'" title="'.esc_html__('Edit', 'grandtour' ).'"><i class="fa fa-edit"></i></a>';
			
			$return_html.= '<a href="javascript:;" class="ppb_duplicate" data-builder-id="'.esc_attr($item_id).'" title="'.esc_html__('Duplicate', 'grandtour' ).'"><i class="fa fa-copy"></i></a>';
		}
		
		$return_html.= '<a href="javascript:;" class="ppb_remove" data-builder-id="'.esc_attr($item_id).'" title="'.esc_html__('Remove', 'grandtour' ).'"><i class="fa fa-trash"></i></a>';
		
		$return_html.= '</div>';
		
	    return $return_html;
	}
	else
	{
		return '';
	}
}

function grandtour_live_builder_end_wrapper($item_id = '')
{
	//Check if live content builder mode
	if(isset($_GET['ppb_live']) && !empty($item_id))
	{
	    return '</div>';
	}
	else
	{
		return '';
	}
}

function grandtour_get_post_view($post_id = '', $raw = false)
{
	if(!empty($post_id) && function_exists('pvc_get_post_views'))
	{
		if($raw)
		{
			if(GRANDTOUR_THEMEDEMO)
			{
				$number_view_format = 544;
			}
			else
			{
				$number_view_format = pvc_get_post_views($post_id);
			}
			
			return $number_view_format;
		}
		else
		{
			if(GRANDTOUR_THEMEDEMO)
			{
				$number_view_format = '3K';
			}
			else
			{
				$number_view = pvc_get_post_views($post_id);
				
				$precision = 1;
				if ($number_view >= 1000 && $number_view < 1000000) 
				{
				    $number_view_format = number_format($number_view/1000,$precision).'K';
				} 
				else if ($number_view >= 1000000) 
				{
				    $number_view_format = number_format($number_view/1000000,$precision).'M';
				}
				else
				{
				    $number_view_format = $number_view;
				}
			}
		}
		
		return $number_view_format;
	}
	else
	{
		return 0;
	}
}

function grandtour_get_post_share($post_id = '', $raw = false)
{
	if($raw)
	{
		if(function_exists('pssc_all'))
		{
		    if(GRANDTOUR_THEMEDEMO)
		    {
		    	$number_share_format = 1200;
		    }
		    else
		    {
		    	$number_share_format = pssc_all($post_id);
		    }
		}
		else
		{
			$number_share_format = 0;
		}
	    
	    return $number_share_format;
	}
	else
	{
		if(GRANDTOUR_THEMEDEMO)
		{
			$number_share = 1200;
			$precision = 1;
			
			if ($number_share >= 1000 && $number_share < 1000000) 
			{
			    $number_share_format = number_format($number_share/1000,$precision).'K';
			} 
			else if ($number_share >= 1000000) 
			{
			    $number_share_format = number_format($number_share/1000000,$precision).'M';
			}
			return $number_share_format;
		}
		else
		{	
			if(!empty($post_id) && function_exists('pssc_all'))
			{
				$number_share = pssc_all($post_id);
				$precision = 1;
				
				if ($number_share >= 1000 && $number_share < 1000000) 
				{
			    	$number_share_format = number_format($number_share/1000,$precision).'K';
			    } 
			    else if ($number_share >= 1000000) 
			    {
			    	$number_share_format = number_format($number_share/1000000,$precision).'M';
			    }
			    else
			    {
				    $number_share_format = $number_share;
			    }
			    return $number_share_format;
			}
			else
			{
				return 0;
			}
		}
	}
}

function grandtour_get_initial_tour_query()
{
	$query_string = '&orderby=post_date&order=DESC&post_type=tour&suppress_filters=0&post_status=publish';
	
	return $query_string;
}

function grandtour_format_tour_price($tour_price = 0)
{
	$return_html = '';
	if(!empty($tour_price) && is_numeric($tour_price))
	{
		$tg_tour_currency = kirki_get_option('tg_tour_currency');
		$tg_tour_currency_display = kirki_get_option('tg_tour_currency_display');
		$tg_tour_currency_thousand_sep = kirki_get_option('tg_tour_currency_thousand_sep');
		$tg_tour_currency_decimal_sep = kirki_get_option('tg_tour_currency_decimal_sep');
		$tg_tour_currency_decimal_number = kirki_get_option('tg_tour_currency_decimal_number');
		
		if($tg_tour_currency_display == 'before')
		{
			$return_html.= $tg_tour_currency;
		}
		
		$return_html.= number_format(floatval($tour_price),$tg_tour_currency_decimal_number,$tg_tour_currency_decimal_sep,$tg_tour_currency_thousand_sep);
		
		if($tg_tour_currency_display == 'after')
		{
			$return_html.= $tg_tour_currency;
		}
		
		return $return_html;
	}
	else if(!is_numeric($tour_price))
	{
		$return_html = esc_html($tour_price);
		return $return_html;
	}
	else
	{
		return 0;
	}
}

function grandtour_set_recently_view_tours()
{
	$tg_post = grandtour_get_wp_post();
	
	if(!isset($_COOKIE['grandtour_recently_view_tours'])) 
	{
		$recently_view_tours = array();
		$recently_view_tours[] = $tg_post->ID;
		
		setcookie('grandtour_recently_view_tours', json_encode($recently_view_tours), strtotime( '+2 days' ), '/');
	}
	else
	{
		$recently_view_tours = json_decode($_COOKIE['grandtour_recently_view_tours']);
		
		if(!in_array($tg_post->ID, $recently_view_tours))
		{
			$recently_view_tours[] = $tg_post->ID;
		}
		
		setcookie('grandtour_recently_view_tours', json_encode($recently_view_tours), strtotime( '+2 days' ), '/');
	}
}

function grandtour_get_recently_view_tours()
{
	$recently_view_tours = array();
	
	if(isset($_COOKIE['grandtour_recently_view_tours'])) 
	{
		$recently_view_tours = json_decode($_COOKIE['grandtour_recently_view_tours']);
	}
	
	return array_reverse($recently_view_tours);
}

function grandtour_get_demo_url($path = '')
{
	$demo_url = 'http://themes.themegoods.com/grandtour/demo'.$path;
	return $demo_url;
}

function grandtour_get_tour_duration($tour_id = '')
{
	$return_html = '';
	
	if(!empty($tour_id))
	{
		$tour_days = get_post_meta($tour_id, 'tour_days', true);
		$tour_hours = get_post_meta($tour_id, 'tour_hours', true);
		
		if($tour_days > 1)
		{
			$return_html.= intval($tour_days).'&nbsp;';
			$return_html.= esc_html__("days", 'grandtour');
		}
		else if(!empty($tour_hours))
		{
			$return_html.= intval($tour_hours).'&nbsp;';
			
			if($tour_hours > 1)
			{
				$return_html.= esc_html__("Hours", 'grandtour');
			}
			else
			{
				$return_html.= esc_html__("Hour", 'grandtour');
			}
		}
		else
		{
			$return_html.= intval($tour_days).'&nbsp;';
			$return_html.= esc_html__("day", 'grandtour');
		}
		
		//If single day tour
		if(intval($tour_days) == 1)
		{
			$tour_available_days = get_post_meta($tour_id, 'tour_available_days', true);
			$i = 0;
			$len = count($tour_available_days);
			
			if($len > 0)
			{
				$return_html.= '<a href="javascript:;" class="tooltip" title="'.esc_html__("Available on ", 'grandtour');
				
				if(!empty($tour_available_days) && is_array($tour_available_days))
				{
					foreach($tour_available_days as $tour_available_day)
					{
						$available_days = grandtour_get_days();
						if(isset($available_days[$tour_available_day]))
						{
							$return_html.= $available_days[$tour_available_day];
						}
						else
						{
							$return_html.= ucfirst($tour_available_day);
						}
						
						if ($i != $len - 1) 
						{
							$return_html.= ',&nbsp;';
						}
						
						$i++;
					}
				}
				
				$return_html.= '"><span class="ti-info-alt"></span></a>';
			}
		}
	}
	
	return $return_html;	
}

function grandtour_themegoods_action() 
{
	$pp_verified_envato_grandtour = get_option("pp_verified_envato_grandtour");
	
	if(!$pp_verified_envato_grandtour OR empty($pp_verified_envato_grandtour))
	{
		if(defined('THEMEGOODS') && THEMEGOODS)
		{
			update_option("pp_verified_envato_grandtour", true);
			update_option("pp_envato_personal_token", '[ThemeGoods Activation]');
		}
		
		if(defined('ENVATO_HOSTED_SITE')) 
		{
	    	update_option("pp_verified_envato_grandtour", true);
			update_option("pp_envato_personal_token", '[Envato Hosted Activation]');
		}
	}
}

function grandtour_starts_with($haystack, $needle) 
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
?>
