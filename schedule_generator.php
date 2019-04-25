<?php
function generate_schedule_table( $arr ) {
  $times = array();
  $waitlists = array();
  for ( $i = 0; $i < 30; $i++ ) {
    $times[1][$i] = false;
    $times[2][$i] = false;
    $times[3][$i] = false;
    $times[4][$i] = false;
    $times[5][$i] = false;
    $waitlists[1][$i] = false;
    $waitlists[2][$i] = false;
    $waitlists[3][$i] = false;
    $waitlists[4][$i] = false;
    $waitlists[5][$i] = false;
  }
  foreach ( $arr as $course_code => $class_info ) {
    list( $days, $meetingtime ) = explode(' ', $class_info['time']);
    list( $starttimestr, $endtimestr ) = explode('-', $meetingtime);
    $days_arr = str_split($days);
    $starttime = $endtime = 0;
    $pm = $oclock = false;
    if ( substr($starttimestr, -2) == 'pm' ) {
      $pm = true;
    }
    if ( strstr($starttimestr, ':') ) {
      list($starthr, $startmin) = explode(':', substr($starttimestr, 0, -2));
      $oclock = false;
    } else {
      $starthr = substr($starttimestr, 0, -2);
      $startmin = 0;
      $oclock = true;
    }
    $starttime = (int)((ampm_to_mil($starthr, $pm) - 8) * 2);
    if ( !$oclock ) {
      $starttime += 1;
    }
    $pm = $oclock = false;
    if ( substr($endtimestr, -2) == 'pm' ) {
      $pm = true;
    }
    if ( strstr($endtimestr, ':') ) {
      list($endhr, $endmin) = explode(':', substr($endtimestr, 0, -2));
      $oclock = false;
    } else {
      $endhr = substr($endtimestr, 0, -2);
      $endmin = 0;
      $oclock = true;
    }
    $endtime = (int)((ampm_to_mil($endhr, $pm) - 8) * 2);
    if ( !$oclock ) {
      $endtime += 1;
    }
    $days_num = array();
    for ( $i = 0; $i < count($days_arr); $i++ ) {
      $days_num[$i] = dotw_alpha_to_num($days_arr[$i]);
    }
    for ( $i = 0; $i < count($days_num); $i++ ) {
      for ( $j = $starttime; $j < $endtime; $j++ ) {
        if ( $times[$days_num[$i]][$j] !== false ) {
          $times[$days_num[$i]][$j] .= ' / ' . $course_code;
        } else {
          $times[$days_num[$i]][$j] = $course_code;
        }
        if ( $class_info['waitlist'] === true ) {
          $waitlists[$days_num[$i]][$j] = $course_code;
        }
      }
    }
  }
  $str = "<table class=\"table table-bordered table-condensed table-striped table-hover\"><tr><th></th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th></tr>";
  for ( $i = 0; $i < 30; $i++ ) {
    $str .= "<tr><td>" . mil_to_12(floor($i/2 + 8)) . (($i % 2 == 1) ? ':30' : '') . (($i/2+8) >= 12 ? 'pm' : 'am') . "</td>";
    for ( $j = 1; $j <= 5; $j++ ) {
      if ( $waitlists[$j][$i] !== false ) {
        $str .= "<td class=\"warning\">" . $times[$j][$i] . "</td>";
      } elseif ( $times[$j][$i] !== false ) {
        $str .= "<td class=\"success\">" . $times[$j][$i] . "</td>";
      } else {
        $str .= "<td></td>";
      }
    }
    $str .= "</tr>";
  }
  $str .= "</table>";
  return $str;
}

function ampm_to_mil ( $time_ampm, $pm ) {
  if ( $pm ) {
    if ( $time_ampm == 12 ) {
      return 12;
    }
    return $time_ampm + 12;
  } else {
    if ( $time_ampm == 12 ) {
      return 0;
    }
    return $time_ampm;
  }
}

function mil_to_ampm ( $time_mil, $ampm ) {
  return $time_mil >= 12 ? ($time_mil - 12) . 'pm' : $time_mil . 'am';
}

function mil_to_12 ( $time_mil, $ampm ) {
  return $time_mil > 12 ? ($time_mil - 12) : $time_mil;
}

function dotw_num_to_alpha( $num ) {
  if ( $num == 1 ) {
    return 'm';
  } else if ( $num == 2 ) {
    return 't';
  } else if ( $num == 3 ) {
    return 'w';
  } else if ( $num == 4 ) {
    return 'r';
  } else if ( $num == 5 ) {
    return 'f';
  } else if ( $num == 6 ) {
    return 's';
  } else {
    return 'u';
  }
}

function dotw_alpha_to_num( $alpha ) {
  $alpha = strtolower($alpha);
  if ( $alpha == 'm' ) {
    return 1;
  } else if ( $alpha == 't' ) {
    return 2;
  } else if ( $alpha == 'w' ) {
    return 3;
  } else if ( $alpha == 'r' ) {
    return 4;
  } else if ( $alpha == 'f' ) {
    return 5;
  } else if ( $alpha == 's' ) {
    return 6;
  } else if ( $alpha == 'u' ) {
    return 7;
  } else {
    return -1;
  }
}
