<?php defined("SYSPATH") or die("No direct script access.") ?>
  <script type="text/javascript" charset="utf-8">
    <? if (stristr( request::user_agent("agent"),'ipad')): ?>
      var or_mngr = new JphUtil_OrientationManager( 768, 1024); // iPad version
    <? else: ?>
      var or_mngr = new JphUtil_OrientationManager( 320, 480); // iPhone version
    <? endif ?>
   or_mngr.Init();
  </script>

<div id="slider-overlay" style="display:block">
<div class="toolbar" id="slider-toolbar-top">
<a class="backbutton" href="<?= ORM::factory("item", $theme->item()->parent_id)->url() ?>"><?= ORM::factory("item", $theme->item()->parent_id)->title ?></a>
</div>
</div>
<div id="slider-container" style="display:block">
<div class="slide"> 
<img src="<?= $item->resize_url() ?>"/>
</div>
</div>
