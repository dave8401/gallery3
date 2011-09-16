<?php defined("SYSPATH") or die("No direct script access.") ?>
  <? $children_all = $item->viewable()->children(); ?>
  <script type="text/javascript" charset="utf-8">
    <? if (stristr( request::user_agent("agent"),'ipad')): ?>
      var or_mngr = new JphUtil_OrientationManager( 768, 1024); // iPad version
    <? else: ?>
      var or_mngr = new JphUtil_OrientationManager( 320, 480); // iPhone version
    <? endif ?>
   or_mngr.Init();
  </script>
  <!-- PRELOAD IMAGES -->
  <div id="preloader"></div>
  <!-- THUMBNAILS -->
  <div class="toolbar" id="thumbs-toolbar-top">
          <? if ($theme->item()->parent_id > 0): ?>
            <a class="backbutton" href="<?= ORM::factory("item", $theme->item()->parent_id)->url() ?>"><?= ORM::factory("item", $theme->item()->parent_id)->title ?></a>
          <? endif ?>
        <div class="center">
          <?= html::purify($item->title) ?>
        </div>
          <? if ($user->guest): ?>
            <a class="button" href="<?= url::site("login/html")?>"><?= t("Login") ?></a>
          <? else: ?>
            <a class="button" href="<?= url::site("logout?csrf=".access::csrf_token()."&amp;continue_url=" . urlencode(url::abs_site(""))) ?>"><?= t("Logout") ?></a>
          <? endif ?>
  </div>
	
  <div id="thumbs-container">
    <div id="thumbs-images-container"></div>
    <div id="thumbs-load-more" onclick="LoadMore()"><?= t("Load more...") ?></div>	
    <div id="thumbs-count-text"></div>
  </div>

  <!-- SLIDER -->
  <div id="slider-overlay">
    <div class="toolbar" id="slider-toolbar-top">
      <a class="backbutton" href="javascript: app.ShowThumbsAction();"><?= $theme->item()->title ?></a> 
      <div class="center" id="navi-info"></div>
    </div>

    <div class="toolbar" id="slider-toolbar-bottom">
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
          <td>
            <a class="navi-button" id="navi-prev" href="javascript: void(0);"></a> 
          </td>
          <td style="width: 80px;">
            <a class="navi-button" id="navi-play" href="javascript: void(0);"></a>
            <a class="navi-button" id="navi-pause" href="javascript: void(0);"></a>
          </td>
          <td>
            <a class="navi-button" id="navi-next" href="javascript: void(0);"></a>
          </td>
        </tr>
      </table>
    </div>
  </div>
	
  <div id="slider-container"></div>

  <?= $theme->script("jaipho-main-src.js") ?>

  <script type="text/javascript">
    // load images
    var dao = new Jph_Dao();
    <? if (count($children)): ?>
      <? for ($i = 0; $i < $children_count; $i++): ?>
        <? $child = $children_all[$i] ?>
        dao.ReadImage(<?= imobile::itemlink($child, $i) ?>);
      <? endfor ?>
    <? endif ?>

    // global reference to jaipho application
    var app;

    function init_jaipho()
    {
      // start jaipho
      app = new Jph_Application( dao, or_mngr, '');
      app.Init();
      app.Run();
    }

    function LoadMore()
    {
      app.LoadMoreThumbs();
    }
  </script>

