<?php

	
if( ! function_exists('mikrotikRateLimit')) {

      function mikrotikRateLimit($object, $prefix = NULL)
      {
          $v = (array) $object;
          
          return         "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                         "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                         "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                         "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                         "{$v[$prefix.'max_up']}{$v[$prefix.'max_up_unit'][0]}/".
                         "{$v[$prefix.'max_down']}{$v[$prefix.'max_down_unit'][0]} ".
                         "1/1 1 ".
                         "{$v[$prefix.'min_up']}{$v[$prefix.'min_up_unit'][0]}/".
                         "{$v[$prefix.'min_down']}{$v[$prefix.'min_down_unit'][0]}";
      }
}

function makeExpiry($units, $unit, $format = 'Y-m-d H:i:s')
  {
    $val = Carbon::now();
    $add = "add".$unit;
    $val->$add( $units );
    return $val->format($format);
  }

  function pr($data) {
  echo "<pre>";
  print_r($data);
  echo "</pre>";
  exit();
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
}
