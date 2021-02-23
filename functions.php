<?php

/**
 * @author            Jasper van Doorn
 * @version           1
 */

defined('ABSPATH') || exit;

/**
 * Import Custom Walker
 */
require plugin_dir_path(__FILE__) . 'prikr-custom-walker.php';


/**
 * Merge new arguments to widget menus
 */
function prikr_custom_menu_args($args)
{
  return array_merge($args, array(
    'walker' => new Prikr_Custom_Walker(),
  ));
}
add_filter('widget_nav_menu_args', 'prikr_custom_menu_args');


/**
 * Filter through 'the_content', 'the_excerpt' and 'widget_text'
 */
add_filter('the_content', 'prikr_add_rel_no_follow');
add_filter('widget_text', 'prikr_add_rel_no_follow');
add_filter('the_excerpt', 'prikr_add_rel_no_follow');


/**
 * Add the actual nofollow to all the links
 */
function prikr_add_rel_no_follow($content)
{
  return preg_replace_callback('/<a[^>]+/', 'prikr_modify_links', $content);
}

/**
 * Modify the links
 */
function prikr_modify_links($matches)
{

  $link = $matches[0];
  $sitelink = get_bloginfo('url');

  if (strpos($link, 'rel') === false) {
    $link = preg_replace("%(href=\S(?!$sitelink))%i", 'rel="nofollow" $1', $link);
  } elseif (preg_match("%href=\S(?!$sitelink)%i", $link)) {
    $link = preg_replace('/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link);
  }

  return $link;
}
