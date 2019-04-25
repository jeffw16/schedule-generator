# schedule-generator
Schedule generator used to render and display my college class schedule.

It is currently running on https://www.cs.utexas.edu/~wang/schedule (as of 2019 - if you see this many years later, it might not be there anymore).

This was written in PHP because the UTCS web server uses a LAMP stack.

The actual code is located in `schedule_generator.php`. An example of how to interface with the schedule generator is located in `demo.php`. Essentially, just create an associated array as shown in `demo.php` and pass it in to the `generate_schedule_table()` function.
