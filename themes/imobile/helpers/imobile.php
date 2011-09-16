<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2010 Bharat Mediratta
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

class imobile_Core {
  public static function itemlink($item,$n) {
    access::required("view", $item);

    if (stristr( request::user_agent("agent"),'ipad')) {
      $thsize = 80;
    } else {
      $thsize = 75;
    }

    if ($item->thumb_width <= $item->thumb_height) {
      $size = "width:".$thsize."px";
      $sqleft = 0;
      $sqtop = ($thsize/2 - ($item->thumb_height * ($thsize / $item->thumb_width)) / 2);
    } else {
      $size = "height:".$thsize."px";
      $sqleft = ($thsize/2 - ($item->thumb_width * $thsize / $item->thumb_height) / 2);
      $sqtop = 0;
    }

    $arguments  = array();
    $arguments[] = $n;
    if ($item->is_album()) {
      $arguments[] = "'".$item->url()."'";  
    } else {
      if ($item->is_movie()) {
          $arguments[] = "'".$item->file_url()."\"'";
      } else {
          $arguments[] = "'".$item->resize_url()."'";
      }
    }
    if ($item->has_thumb()) {
      $arguments[] = "'".$item->thumb_url()."'";
    }
    if ($item->is_album()) {
      $arguments[] = "'".html::purify($item->title)."'";
      $arguments[] = "''";
      $arguments[] = "'album'";
    } else {
      if($item->is_movie()) {
        $arguments[] = "''"; 
        $arguments[] = "''";
        $arguments[] = "'video'";
      } else {
        $arguments[] = "''"; 
        $arguments[] = "''";
        $arguments[] = "'image'";
      }
    }
    $arguments[] = "'".$size.";left:".$sqleft."px;top:".$sqtop."px;'";
    return join(',', $arguments);
  }
}

