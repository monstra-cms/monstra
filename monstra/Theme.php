<?php

class Theme
{
  public static function getTemplate($template = null)
  {
    include THEMES_PATH . '/' . Config::get('site.theme') . '/' . $template . '.php';
  }
}
