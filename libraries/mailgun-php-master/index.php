<?php

/*

# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-ffaeadcdd49631fe8a0626dfa26e4a94');
$domain = "sandboxbdf8cfe9c51e4f9ca2cfed956d2bae00.mailgun.org";

# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Excited User <mailgun@postmaster@sandboxbdf8cfe9c51e4f9ca2cfed956d2bae00.mailgun.org>',
    'to'      => 'Baz <YOU@suarezandrew441@gmail.com>',
    'subject' => 'Hello',
    'text'    => 'Testing some Mailgun awesomness!'
));


*/
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-ffaeadcdd49631fe8a0626dfa26e4a94');
$domain = 'sandboxbdf8cfe9c51e4f9ca2cfed956d2bae00.mailgun.org';




# Issue the call to the client.
//$result = $mgClient->get("$domain/stats/total", array(
//    'event' => array('accepted', 'delivered', 'failed'),
//    'duration' => '1m',
//   // 'from' => array('mrjesuserwinsuarez@gmail.com1sdsd')
//));





$queryString = array(
    'begin'        => 'Fri, 3 May 2013 09:00:00 -0000',
    'end'          => time(),
    'ascending'    => 'yes',
    'limit'        =>  2
);

# Make the call to the client.
$result = $mgClient->get("$domain/events", $queryString);






//$queryString = array('event' => 'rejected OR failed');
//# Make the call to the client.
//$result = $mgClient->get("$domain/events", $queryString);
print "<pre>";
print_r($result);
print "</pre>";
