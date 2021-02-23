<?php

/**
 * @author            Jasper van Doorn
 * @version           1
 */

defined('ABSPATH') || exit;

class Prikr_Custom_Walker extends Walker_Nav_Menu
{

  function start_el(&$output, $item, $depth = 0, $arg = array(), $id = 0)
  {
    $object = $item->object;
    $type = $item->type;
    $title = $item->title;
    $description = $item->description;
    $permalink = $item->url;

    $output .= "<li class='" .  implode(" ", $item->classes) . "'>";

    if ($permalink && $permalink != '#') {
      $output .= '<a href="' . $permalink . '">';

      if (prikr_parse_external_url($permalink) !== false) {
        $url = prikr_parse_external_url($permalink);
        $output = '<a href="' . $url['url'] . ' rel="' . $url['rel'] . '" target="' . $url['target'] . '">';
      } else {
        $output .= '<a href="' . $permalink . '">';
      }
    } else {
      $output .= '<span>';
    }

    $output .= $title;

    if ($description != '' && $depth == 0) {
      $output .= '<small class="description">' . $description . '</small>';
    }

    if ($permalink && $permalink != '#') {
      $output .= '</a>';
    } else {
      $output .= '</span>';
    }
  }
}

function prikr_parse_external_url($url = '')
{

  // Abort if parameter URL is empty
  if (empty($url)) {
    return false;
  }

  // Parse home URL and parameter URL
  $link_url = parse_url($url);
  $home_url = parse_url(home_url());

  // Decide on target
  if (empty($link_url['host'])) {
    // Is an internal link
    $target = '_self';
    $rel = 'follow';
  } elseif ($link_url['host'] == $home_url['host']) {
    // Is an internal link
    $target = '_self';
    $rel = 'follow';
  } else {
    // Is an external link
    $target = '_blank';
    $rel = 'nofollow';
  }

  // Return array
  $output = array(
    'target'    => $target,
    'url'       => $url,
    'rel'       => $rel
  );

  return $output;
}
