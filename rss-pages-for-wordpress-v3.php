<?php
/*
Plugin Name: RSS Pages For Wordpress v3+
Plugin URI: http://www.thepicklingjar.com/code/rss-pages-for-wordpress-v3/
Description: Display wordpress pages in a rss feed, just enable as the headers are already added
Author: The Pickling Jar Ltd
Version: 2.6.1
Author URI: http://www.thepicklingjar.com/
*/

function feed_rss2_pages($comments = "") {
	header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'."\n";

	$bloginfo_rss_name = get_bloginfo_rss('name');
	$bloginfo_rss_description = get_bloginfo_rss('description');
	$bloginfo_rss_url = get_bloginfo_rss('url');
	$rss_language = get_option('rss_language');
	$headerdone = 0;
	$rss_pages_feedcontent = get_option('rss_pages_feedcontent');

	$q = new WP_Query(array('post_type'=>'page', 'post_status'=>'publish', 'orderby'=>'modified', 'posts_per_page'=>25));
	while ($q->have_posts()) : $q->the_post();
		if($headerdone == 0){
			$headerdone = 1;
			echo '<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
<channel>
	<title>'.$bloginfo_rss_name.'</title>
	<atom:link href="'.$bloginfo_rss_url.'/?feed=pages-rss2" rel="self" type="application/rss+xml" />
	<link>'.$bloginfo_rss_url.'/</link>
	<description>'.$bloginfo_rss_description.'</description>
		
        <pubDate>'.the_modified_date('D, d M Y H:i:s O', '', '', false).'</pubDate>
	<generator>http://www.thepicklingjar.com/#rsspages</generator>
	<language>'.$rss_language.'</language>';
		}
		echo "<item>";
		echo "<title>";
		echo the_title_rss();
		echo "</title>";
		echo "<link>";
		echo the_permalink();
		echo "</link>";
		echo '<guid isPermaLink="false">';
		echo the_permalink();
		echo '</guid>';
		echo "<pubDate>";
		echo the_modified_date('D, d M Y H:i:s O', '', '', false);
		echo "</pubDate>";
		if($rss_pages_feedcontent == 'full'){
			echo "<description><![CDATA[";
			the_excerpt_rss(255);
			echo "]]></description>";
			echo "<content:encoded><![CDATA[";
			the_content_feed('rss2');
			echo "]]></content:encoded>";
		}
		else {
			echo "<description><![CDATA[Please visit <a href='";
			the_permalink();
			echo "'>";
			echo the_title_rss();
			echo "</a> for the full update]]></description>";
			echo "<content:encoded><![CDATA[Please visit <a href='";
			the_permalink();
			echo "'>";
			echo the_title_rss();
			echo "</a> for the full update]]></content:encoded>";
		}
		do_action('rss2_item');
		echo "</item>\n";
	endwhile;
	echo '</channel>'."\n";
	echo '</rss>';
}

function feed_rss_pages($comments = ""){
	header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

	$bloginfo_rss_name = get_bloginfo_rss('name');
	$bloginfo_rss_url = get_bloginfo_rss('url');
	$rss_language = get_option('rss_language');
	$bloginfo_rss_description = get_bloginfo_rss('description');
	$headerdone = 0;
	$rss_pages_feedcontent = get_option('rss_pages_feedcontent');

	$q = new WP_Query(array('post_type'=>'page', 'post_status'=>'publish', 'orderby'=>'modified', 'posts_per_page'=>25));
	while ($q->have_posts()) : $q->the_post();
		if($headerdone == 0){
			$headerdone = 1;
			echo '<!-- generator="http://www.thepicklingjar.com/#rsspages" -->
<rss version="0.92">
<channel>
        <title>'.$bloginfo_rss_name.'</title>
        <link>'.$bloginfo_rss_url.'</link>
        <description>'.$bloginfo_rss_description.'</description>
        <lastBuildDate>'.the_modified_date('D, d M Y H:i:s O', '', '', false).'</lastBuildDate>
        <docs>http://backend.userland.com/rss092</docs>
        <language>'.$rss_language.'</language>';
		}
        	echo "<item>";
		echo "<title>";
		echo the_title_rss();
		echo "</title>";
		if($rss_pages_feedcontent == 'full'){
			echo "<description><![CDATA[";
			the_content_feed('rss');
			echo "]]></description>";
		}
		else {
			echo "<description><![CDATA[Please visit <a href='";
			the_permalink();
			echo "'>";
			echo the_title_rss();
			echo "</a> for the full update]]></description>";
		}
		echo "<link>";
		the_permalink();
		echo "</link>";
                do_action('rss_item');
		echo "</item>\n";
	endwhile;
	echo '</channel>';
	echo '</rss>';
}

function feed_atom_pages($comments = ""){
	header('Content-Type: application/atom+xml; charset=' . get_option('blog_charset'), true);
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

        $bloginfo_rss_name = get_bloginfo_rss('name');
        $bloginfo_rss_home = get_bloginfo_rss('home');
        $bloginfo_rss_url = get_bloginfo_rss('url');
        $rss_language = get_option('rss_language');
        $bloginfo_rss_description = get_bloginfo_rss('description');
	$rss_pages_feedcontent = get_option('rss_pages_feedcontent');

	$q = new WP_Query(array('post_type'=>'page', 'post_status'=>'publish', 'orderby'=>'modified', 'posts_per_page'=>25));
	while ($q->have_posts()) : $q->the_post();
		if($headerdone == 0){
			$headerdone = 1;
			echo '<feed
  xmlns="http://www.w3.org/2005/Atom"
  xmlns:thr="http://purl.org/syndication/thread/1.0"
  xml:lang="'.$rss_language.'"
  xml:base="'.$bloginfo_rss_home.'/">';
		        echo '<title type="text">'.$bloginfo_rss_name.'</title>
        <subtitle type="text">'.$bloginfo_rss_description.'</subtitle>
        <updated>'.the_modified_date("Y-m-d\TH:i:s\Z", '', '', false).'</updated>
        <generator>http://www.thepicklingjar.com/#rsspages</generator>
        <link rel="alternate" type="text/html" href="'.$bloginfo_rss_home.'/" />
	<id>'.$bloginfo_rss_home.'/?feed=pages-atom</id>
        <link rel="self" type="application/atom+xml" href="';
			echo self_link();
			echo '" />';
		}
		echo "<entry>";
		echo "<author>";
		echo "<name>";
		echo $bloginfo_rss_name;
		echo "</name>";
		echo "<uri>";
		echo $bloginfo_rss_home;
		echo "</uri>";
		echo "</author>";
		echo '<title type="';
		html_type_rss();
		echo '">';
		echo "<![CDATA[";
		echo the_title_rss();
		echo "]]></title>";
		echo '<link rel="alternate" type="text/html" href="';
		the_permalink_rss();
		echo '" />';
		echo '<id>';
		the_permalink();
		echo '</id>';
		echo '<updated>'.the_modified_date("Y-m-d\TH:i:s\Z", '', '', false).'</updated>';
		echo '<published>'.get_the_date('Y-m-d\TH:i:s\Z').'</published>';
		the_category_rss('atom');
                if($rss_pages_feedcontent == 'full'){
			echo '<summary type="';
			html_type_rss();
			echo '"><![CDATA[';
			the_excerpt_rss(255);
			echo ']]></summary>';
			echo '<content type="';
			echo html_type_rss();
			echo '" xml:base="'.$bloginfo_rss_home.'/"><![CDATA[';
			the_content_feed('atom');
			echo ']]></content>';
                }
                else {
			echo '<summary type="';
			html_type_rss();
			echo '"><![CDATA[Please visit <a href="';
			the_permalink();
			echo '">';
                        echo the_title_rss();
			echo '</a> for the full update.]]></summary>';
			echo '<content type="';
			echo html_type_rss();
			echo '" xml:base="'.$bloginfo_rss_home.'/"><![CDATA[Please visit <a href="';
                        the_permalink();
                        echo '">';
                        echo the_title_rss();
			echo '</a> for the full update.]]></content>';
                }
		do_action('atom_entry');
		echo '</entry>';
	endwhile;
	echo '</feed>';
}


function add_rss_pages() {
add_feed('pages-rss','feed_rss_pages');
add_feed('pages-rss2','feed_rss2_pages');
add_feed('pages-atom','feed_atom_pages');
}
function add_rss_pages_to_header(){
	echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name').' Pages Rss Feed" href="'.get_bloginfo('wpurl').'/?feed=pages-rss" />'."\n";
	echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name').' Pages Rss2 Feed" href="'.get_bloginfo('wpurl').'/?feed=pages-rss2" />'."\n";
	echo '<link rel="alternate" type="application/atom+xml" title="'.get_bloginfo('name').' Pages Atom Feed" href="'.get_bloginfo('wpurl').'/?feed=pages-atom" />'."\n";
}
function rss_pages_install(){
	add_option("rss_pages_feedcontent", 'permalink', '', 'yes');
}
function rss_pages_uninstall(){
	delete_option("rss_pages_feedcontent");
}
function rss_pages_admin_menu(){
	add_options_page('RSS Pages', 'RSS Pages', 'administrator', plugin_basename(__FILE__), 'rss_pages_admin_page');
}
function rss_pages_admin_page(){
?><div class="wrap">
	<h2>RSS Pages For Wordpress 3+ Options</h2>
	<p>Please select the type of content you want in your RSS pages feed</p>
	<form method="post" action="<?php echo plugin_basename(__FILE__); ?>" id='rsspagesoptions'>
		<table>
			<tbody>
			<?php
			$rss_pages_feedcontent = get_option('rss_pages_feedcontent');
			?>
			<tr><td>Content type in feed: </td><td><select name="rss_pages_feedcontent" id='rss_pages_feedcontent'><option value="permalink" <?php if($rss_pages_feedcontent == "permalink") echo "selected='selected'";?>>permalink</option><option value="full" <?php if($rss_pages_feedcontent == "full") echo "selected='selected'";?>>full</option></select></td><td><button onclick="rss_pages_save_settings(); return false;">Save</button</td></tr>
			</tbody>
		</table>
	</form>
	<p><br />Brought to you by <a href="http://www.thepicklingjar.com/">The Pickling Jar Ltd</a></p>
</div>
<?php
}

function rss_pages_save_settings_js() {
?>
<script type="text/javascript" >
function rss_pages_save_settings(){
	jQuery(document).ready(function($) {
		var data = {
			action: 'rss_pages_save_settings',
			rss_pages_feedcontent: jQuery('#rss_pages_feedcontent option:selected').text(),
			_ajax_nonce: '<?php echo wp_create_nonce('rss_pages_nonce'); ?>'
		};
		jQuery.post(ajaxurl, data, function(response) {
			if(response == 'ok'){
				alert('Saved');
			}
			else alert('Something went wrong saving your settings');
		});
	});
}
</script>
<?php
}

function rss_pages_save_settings() {
	check_ajax_referer('rss_pages_nonce');
	update_option('rss_pages_feedcontent', $_POST['rss_pages_feedcontent']);
        echo 'ok';
	die();
}

register_activation_hook(__FILE__,'rss_pages_install');
register_deactivation_hook(__FILE__,'rss_pages_uninstall');
add_action('admin_menu', 'rss_pages_admin_menu');
add_action('admin_head', 'rss_pages_save_settings_js');
add_action('wp_ajax_rss_pages_save_settings', 'rss_pages_save_settings');
add_action('init','add_rss_pages',10,1);
add_action('wp_head','add_rss_pages_to_header');
?>
