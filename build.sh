#!/bin/sh
#This is a script to run the tests and export the bugs database prior to uploading to live site.
clear
echo 'This script runs the test scripts then publishes the bug database to the bugs directory'
echo "CTRL+C to cancel or wait 10 seconds for the script to run"
sleep 10
echo "Running tests..."
./vendor/bin/phpunit --verbose --bootstrap vendor/autoload.php tests

echo "Running codesniffer..."
./vendor/bin/phpcs --ignore=./js,./lib/limonade,./tests/simpletest,./tests/selenium,./lib/recaptchalib.php ./ > codesniff.txt
echo "Finished"
