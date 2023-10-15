<?php

  require_once __DIR__.'/../../config/init.php';

  use App\Utils\Utilities;

  Utilities::redirectUnauthorize();

  $authProvider->signOut();