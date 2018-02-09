<?php

  class BaseController{

    public static function get_user_logged_in(){
      if (isset($_SESSION['user'])) {
          $k_id = $_SESSION['user'];
          $kayttaja = Kayttaja::etsi_kayttaja($k_id);
          return $kayttaja;
      }
      return null;
    }

    public static function check_logged_in(){
      if (!isset($_SESSION['user'])) {
          Redirect::to('/');
      }
    }

  }
