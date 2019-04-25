<?php
/**
 * Schedule Generator
 * @file demo.php
 * @description Demo code that makes use of schedule_generator.php
 * @author Jeffrey Wang
 * @license (c) 2018-2019 Jeffrey Wang. All rights reserved.
*/
require_once('schedule_generator.php');
$links = array(
    '2019fall' => array('Fall 2019', array(
      'CS 439H' => array(
        'name' => 'Principles of Computer Systems (Operating Systems): Honors',
        'instructor' => 'Ahmed Gheith',
        'time' => 'MW 5pm-7pm',
      ),
      'CS 439H-D' => array(
        'name' => 'Computer Organization and Architecture: Honors - Discussion',
        'instructor' => '?',
        'time' => 'F 3pm-5pm',
      ),
      'MAN 327H' => array(
        'name' => 'Innovation and Entrepreneurship: Honors',
        'instructor' => 'Douglas Hannah',
        'time' => 'MW 11am-12:30pm',
      ),
      'ACC 311H' => array(
        'name' => 'Financial Accounting: Honors',
        'instructor' => 'Aysa Dordzhieva',
        'time' => 'TR 11am-12:30pm',
      ),
      'CS 371R' => array(
        'name' => 'Information Retrieval & Web Search',
        'instructor' => 'Raymond Mooney',
        'time' => 'TR 9:30am-11am',
      ),
      'BA 151H' => array(
        'name' => 'Business Honors Lyceum',
        'instructor' => 'Andres Almazan',
        'time' => 'W 4pm-5:30pm',
      ),
      'CS 361S' => array(
        'name' => 'Introduction to Computer Security',
        'instructor' => 'Stephany Coffman-Wolph',
        'time' => 'TR 12:30pm-2pm',
        'waitlist' => true,
      ),
    )),
);

foreach ( $links as $link_id => $link ) {
?>
<h2><?php echo $link[0]; // academic session ?></h2>
<div class="row">
  <div class="col-xs-12 col-md-12">
    <!-- Listing of each class -->
    <ul>
      <?php foreach ( $link[1] as $key => $val ) { ?>
        <li><?php echo $val['waitlist'] === true ? '[WAITLIST] ' : ''; echo $key . ' - ' . $val['name'] . ' - ' . $val['instructor'] . ' - ' . $val['time']; ?></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php
echo generate_schedule_table($link[1]);
