<?php defined("SYSPATH") or die("No direct script access.") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <link rel="apple-touch-icon-precomposed"
          href="<?= url::file(module::get_var("gallery", "apple_touch_icon_url")) ?>" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>
      <? if ($page_title): ?>
        <?= $page_title ?>
      <? else: ?>
        <? if ($theme->item()): ?>
          <? if ($theme->item()->is_album()): ?>
          <?= t("Browse Album :: %album_title", array("album_title" => $theme->item()->title)) ?>
          <? elseif ($theme->item()->is_photo()): ?>
          <?= t("Photo :: %photo_title", array("photo_title" => $theme->item()->title)) ?>
          <? else: ?>
          <?= t("Movie :: %movie_title", array("movie_title" => $theme->item()->title)) ?>
          <? endif ?>
        <? elseif ($theme->tag()): ?>
          <?= t("Browse Tag :: %tag_title", array("tag_title" => $theme->tag()->name)) ?>
        <? else: /* Not an item, not a tag, no page_title specified.  Help! */ ?>
          <?= t("Gallery") ?>
        <? endif ?>
      <? endif ?>
    </title>
    <?= $theme->head() ?>
    <?= $theme->css("imobile.css") ?>
    <? if (stristr( request::user_agent("agent"),'ipad')): ?>
      <?= $theme->css("imobile-ipad.css") ?>
    <? endif ?>
    <?= $theme->script("jaipho-preload-src.js") ?>
    <? if($page_subtype != "login"): ?>
      <script type="text/javascript" charset="utf-8">
        // basic parameters
        var TOOLBARS_HIDE_TIMEOUT		=	5000;
        var SLIDESHOW_ROLL_TIMEOUT		=	4000;
        var SLIDE_SCROLL_DURATION		=	'1.0s';
        var SLIDE_PRELOAD_TIMEOUT		=	1100;
        var SLIDE_PRELOAD_SEQUENCE		=	'1,-1,2';
        var SPLASH_SCREEN_DURATION		=	1000;
        var DEFAULT_STARTUP_MODE		=	'thumbs';  // thumbs, slider, slideshow
	var SLIDE_SPACE_WIDTH                   =       40;

        // advanced parameters
        var ENABLE_SAFARI_HISTORY_PATCH		=	true;
        var MAX_CONCURENT_LOADING_THUMBNAILS	=	4;
        var MAX_CONCURENT_LOADING_SLIDE		=	1;
        var MIN_DISTANCE_TO_BE_A_DRAG		=	50;
        var MAX_DISTANCE_TO_BE_A_TOUCH		=	5;
        var CHECK_ORIENTATION_INTERVAL		=	1000;
        var BLOCK_VERTICAL_SCROLL		=	true;
        var BASE_URL				=	'<?= $theme->url("../imobile/images/") ?>';
        var SLIDE_MAX_IMAGE_ELEMENS		=	50;
	<? if (stristr( request::user_agent("agent"),'ipad')): ?>
		var MAX_LOADING_THUMBNAILS              =       84;
	<? else: ?>
		var MAX_LOADING_THUMBNAILS		=	16;
	<? endif ?>
        // debug parameters
        var DEBUG_MODE				=	false;
        var DEBUG_LEVELS			=	'';
		
        if (DEBUG_MODE)
          JphUtil_Console.CreateConsole( DEBUG_LEVELS);
      </script>
    <? endif ?>
  </head>
    <? if($page_subtype == "login"): ?>
      <body>
      <?= $theme->messages() ?>
      <div id="login" class="current">
      <form action="<?= url::abs_site("") ?>login/auth_html" method="post" id="g-login-form" class="form">
      <input type="hidden" name="csrf" value="<?= access::csrf_token() ?>" />
      <input type="hidden" name="continue_url" value="<?= Session::instance()->get("continue_url") ?>"  />
        <div class="toolbar center" id="login-toolbar-top">
          <?= t("Gallery") ?> - <?= $page_title ?>
        </div>
        <ul class="rounded">
          <li><input type="text" name="name" placeholder="Name" /></li>
          <li><input type="password" name="password" placeholder="Password" /></li>
        </ul>
        <input type="submit" style="margin:0 10px;color:rgba(0,0,0,.9)" class="submit whiteButton" value="<?= t("Login") ?>">
      </form>
      </div>        
    <? else: ?>
      <body onload="init_jaipho()">
      <?= $theme->messages() ?>
      <?= $content ?>
    <? endif ?>
    <?= $theme->page_bottom() ?>
  </body>

