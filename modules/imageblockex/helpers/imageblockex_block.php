<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class ImageBlockEx_block_Core {

  static function get_site_list() {
    return array("image_block" => t("Random Image"));
  }

  static function get_block_code() {

    $delay = module::get_var("imageblockex", "delay", 15);
    $transintype = module::get_var("imageblockex", "transintype", "Fade");
    $transouttype = module::get_var("imageblockex", "transouttype", "Fade");
    $target = module::get_var("imageblockex", "target", "_parent");
    
    $player_path = url::file("modules/imageblockex/player/minislideshow.swf");
    $player_params = "&amp;shuffle=true&amp;useResizes=true&amp;delay=" . $delay . "&amp;showControls=false&amp;transInType=" . $transintype . "&amp;transOutType=" . $transouttype;
    if ($target != "_parent"):
      $player_params .= "&amp;linkTarget=" . $target . ";";
    endif;
    
    $rss_type = module::get_var("imageblockex", "rss_type");
    if ($rss_type == "random"):
      if ((!module::is_active("rss_extra")) or (!module::info("shadowbox"))):
        $rss_type = "default";
      endif;
    endif;

    switch ($rss_type) {
      case "latest":
        $rss_path = url::site("rss/feed/gallery/latest", "http");
        break;
      case "relative":
        if ($item = $theme->item()):
          if (!$item->is_album()):
            $item = $item->parent();
          endif;
          $rss_path = rss::url("gallery/album/{$item->id}");
        else:
          $rss_path = rss::url("tag/tag/{$theme->tag()->id}");
        endif;
        break;
      case "random":
        $rss_path = rss::url("rss_extra/random");
        break;
      case "default":
      default:
        $rss_path = url::site("rss/feed/gallery/album/1", "http");
        break;
    }

    $content  = '<object type="application/x-shockwave-flash" data="' . $player_path . '" width="200" height="200">';
    $content .= '<param name="movie" value="' . $player_path . '" />';
    $content .= '<param name="FlashVars" value="xmlUrl=' . $rss_path . $player_params . '" />';
    $content .= '<param name="wmode" value="transparent" />';
    $content .= '<param name="menu" value="false" />';
    $content .= '<param name="quality" value="high" />';
    $content .= '<h3>' . t("No flash") . '</h3><br />';
    $content .= t("Get") . ' <a href="http://www.macromedia.com/go/getflashplayer" target="_blank">' . t("Flash") . '</a>.';
    $content .= '</object>';

    return $content;
  }

  static function get($block_id, $theme) {
    $block = "";
    switch ($block_id) {
      case "image_block":
        if ((module::get_var("imageblockex", "rss_type") == "relative") and (!$theme->item())):  // should not be used in non-item related pages
          break;
        endif;
        if ((module::get_var("imageblockex", "albumonly")) and ($theme->page_type != "collection")):
          break;
        endif;

        $block = new Block();
        $block->css_id = "g-image-block-ex";
        $block->title = t("Random image");
        $block->content = new View("imageblockex_block.html");
        $block->content->player = self::get_block_code();
        break;
    }

    return $block;
  }
}

?>