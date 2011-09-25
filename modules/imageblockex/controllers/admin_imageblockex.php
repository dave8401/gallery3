<?php defined("SYSPATH") or die("No direct script access.");

class Admin_ImageBlockEx_Controller extends Admin_Controller {

  public function index() {
    $view = new Admin_View("admin.html");
    $view->content = new View("admin_imageblockex.html");
    $view->content->form = $this->_get_setting_form();
    $view->content->help = $this->_get_help_form();

    print $view;
  }

  public function save() {
    access::verify_csrf();
    module::clear_var("imageblockex", "relative");

    $form = $this->_get_setting_form();
    if ($form->validate()) {
      $rss_type     = $form->g_admin_settings->rss_type->value;
      $transintype  = $form->g_admin_settings->transintype->value; 
      $transouttype = $form->g_admin_settings->transouttype->value; 
      $delay        = $form->g_admin_settings->delay->value;
      $target       = $form->g_admin_settings->target->value;
      $album_only   = $form->g_admin_settings->albumonly->value;

      if ($delay == 15):
        module::clear_var("imageblockex", "delay");
      else:
        module::set_var("imageblockex", "delay", $delay);
      endif;

      if ((!$rss_type) or ($rss_type == "default")):
        module::clear_var("imageblockex", "rss_type");
      else:
        module::set_var("imageblockex", "rss_type", $rss_type);
      endif;

      if ((!$transintype) or ($transintype == "Fade")):
        module::clear_var("imageblockex", "transintype");
      else:
        module::set_var("imageblockex", "transintype", $transintype);
      endif;

      if ((!$transouttype) or ($transouttype == "Fade")):
        module::clear_var("imageblockex", "transouttype");
      else:
        module::set_var("imageblockex", "transouttype", $transouttype);
      endif;

      if ($target == "_parent"):
        module::clear_var("imageblockex", "target");
      else:
        module::set_var("imageblockex", "target", $target);
      endif;

      if ($album_only):
        module::set_var("imageblockex", "albumonly", TRUE);
      else:
        module::clear_var("imageblockex", "albumonly");
      endif;

      message::success("Settings saved.");
      url::redirect("admin/imageblockex");
    }

    $view = new Admin_View("admin.html");
    $view->content = new View("admin_imageblockex.html");
    $view->content->form = $form;
    $view->content->help = $this->_get_help_form();
    print $view;
  }

  private function _get_setting_form() {
    $form = new Forge("admin/imageblockex/save", "", "post", array("id" => "g-admin-imageblockex-form"));
    $group = $form->group("g_admin_settings")->label(t("Settings"));
    $group->dropdown("rss_type")
      ->label(t("RSS Type"))
      ->options(array("default" => t("Default (Root Album)"), "latest" => t("Latest"), "relative" => t("Current Album"), "random" => t("Random")))
      ->selected(module::get_var("imageblockex", "rss_type"));
    $group->dropdown("transintype")
      ->label(t("Transition-In Type"))
      ->options(array("Fade" => t("Default (Fade)"), "Blinds" => t("Blinds"), "Fly" => t("Fly"), "Iris" => t("Iris"), "Photo" => t("Photo"), "PixelDissolve" => t("PixelDissolve"), "Rotate" => t("Rotate"), "Squeeze" => t("Squeeze"), "Wipe" => t("Wipe"), "Zoom" => t("Zoom"), "Random" => t("Random")))
      ->selected(module::get_var("imageblockex", "transintype", "Fade"));
    $group->dropdown("transouttype")
      ->label(t("Transition-Out Type"))
      ->options(array("Fade" => t("Default (Fade)"), "Blinds" => t("Blinds"), "Fly" => t("Fly"), "Iris" => t("Iris"), "Photo" => t("Photo"), "PixelDissolve" => t("PixelDissolve"), "Rotate" => t("Rotate"), "Squeeze" => t("Squeeze"), "Wipe" => t("Wipe"), "Zoom" => t("Zoom"), "Random" => t("Random")))
      ->selected(module::get_var("imageblockex", "transouttype", "Fade"));
    $group->input("delay")
      ->label(t("Image Rotation Delay"))
      ->value(module::get_var("imageblockex", "delay", 15));
    $group->input("target")
      ->label(t("Link Target"))
      ->value(module::get_var("imageblockex", "target", "_parent"));
    $group->checkbox("albumonly")
      ->label(t("Show in Albums Only"))
      ->checked(module::get_var("imageblockex", "albumonly"));

    $group->submit("")->value(t("Save"));

    return $form;
  }

  private function _get_help_form() {
    $help  = '<fieldset>';
    $help .= '<legend>Help</legend><ul><br />';
    $help .= '<li><b>RSS Type</b> - type of RSS feed used to create a slideshow.
      <li><b>Transition-in Type</b> - Transition in. Default Fade.
      <li><b>Transition-out Type</b> - Transition Out. Default Fade.
      <li><b>Image Rotation Delay</b> - Number in seconds to display a slide. Default 15.
      <li><b>Link Target</b> - specifies the target for all links in the slideshow. Default _parent.
      <li><b>Show in Albums Only</b> - Make block visible only in album pages. Default False.
      ';
    $help .= '</ul></fieldset>';
    return $help;
  }
}
