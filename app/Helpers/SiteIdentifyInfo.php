<?php

namespace App\Helpers;

 use App\Models\User;

 class SiteIdentifyInfo
{
  public static function copyright()
  {
    $get = '© 2020 Copyright: Xpress Delivery |||';

    return $get;
  }

  public static function app_version()
  {
    $get = 'App Version: 2.0.1';

    return $get;
  }

  public static function getSiteTotalUser()
  {
    $gettotaluser = User::count();

    return $gettotaluser;
  }

  public static function getSiteTitle()
  {
    $getSiteTitle = MsOption::where('option_name', 'site_title')->first();

    return $getSiteTitle->option_value;
    // return "|Online Easy Earning";
  }

  public static function getSiteFavicon()
  {
    $getSiteFavicon = MsOption::where('option_name', 'favicon')->first();
    // $getSiteFavicon = 'favicon.png';
    return $getSiteFavicon->option_value;
  }

  public static function getSiteLogo()
  {
    $getSiteLogo = MsOption::where('option_name', 'logo')->first();
    // $getSiteLogo = 'logo.png';
    return $getSiteLogo->option_value;
  }

  public static function getSiteContactFacebook()
  {
    // $getfb = MsOption::where('option_name','facebook')->first();
    // return $getfb->option_value;
    return 'https://www.facebook.com/msitxpress';
  }

  public static function getSiteContactYoutube()
  {
    // $youtube = MsOption::where('option_name','youtube')->first();
    // return $youtube->option_value;
    return 'https://www.youtube.com/msitxpress';
  }

  public static function getSiteContactGithub()
  {
    // $github = MsOption::where('option_name','github')->first();
    // return $github->option_value;
    return 'https://www.github.com/msitxpress';
  }

  public static function getSiteContactTwitter()
  {
    // $twitter = MsOption::where('option_name','twitter')->first();
    // return $twitter->option_value;
    return 'https://www.twitter.com/msitxpress';
  }

  public static function getSiteContactLinkedin()
  {
    // $linkedin = MsOption::where('option_name','linkedin')->first();
    // return $linkedin->option_value;
    return 'https://www.linkedin.com/msitxpress';
  }

  public static function getSiteContactPhone()
  {
    // $phone = MsOption::where('option_name','phone')->first();
    // return $phone->option_value;
    return '01625568604';
  }

  public static function getSiteContactEmail()
  {
    // $email = MsOption::where('option_name','email')->first();
    // return $email->option_value;
    return 'info@msitxpress.com';
  }
}
