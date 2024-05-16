<?php
/**
 * Created by PhpStorm
 * User: ProgrammerHasan
 * Date: 31-10-2020
 * Time: 10:16 PM
 */

namespace App\Helpers;

/**
 * Gravatar Helper
 */
class GravatarHelper
{
  /**
   * validate_gravatar
   *
   * Check if the email has any gravatar image or not
   *
   * @param  string  $email Email of the User
   * @return bool true, if there is an image. false otherwise
   */
  public static function validate_gravatar($email)
  {
    $hash = md5($email);
    $uri = 'http://www.gravatar.com/avatar/'.$hash.'?d=404';
    $headers = @get_headers($uri);
    if (! preg_match('|200|', $headers[0])) {
      $has_valid_avatar = false;
    } else {
      $has_valid_avatar = true;
    }

    return $has_valid_avatar;
  }

  /**
   * gravatar_image
   *
   *  Get the Gravatar Image From An Email address
   *
   * @param  string  $email User Email
   * @param  int  $size  size of image
   * @param  string  $d     type of image if not gravatar image
   * @return string        gravatar image URL
   */
  public static function gravatar_image($email, $size = 0, $d = '')
  {
    $hash = md5($email);
    $image_url = 'http://www.gravatar.com/avatar/'.$hash.'?s='.$size.'&d='.$d;

    return $image_url;
  }
}
