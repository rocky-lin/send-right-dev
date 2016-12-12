<?php
function is_localhost() {
    $whitelist = array( '127.0.0.1', '::1' );
    if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return true;
}
// $isLocal = true;


if(is_localhost() === true) {

 //main variables
//print " host " . $_SERVER[HTTP_HOST];
 define("SITE_URL", 'http://localhost/rocky/send-right-dev/extension/campaign/');

 define("SITE_DIRECTORY", 'E:/xampp/htdocs/rocky/send-right-dev/extension/campaign/');



 //elements.json file directory
 define("ELEMENTS_DIRECTORY",SITE_DIRECTORY.'elements.json');

 //uploads directory,url
 define("UPLOADS_DIRECTORY",SITE_DIRECTORY.'uploads/');


 define("UPLOADS_URL",SITE_URL.'uploads/');

//EXPORTS directory,url
 define("EXPORTS_DIRECTORY",SITE_DIRECTORY.'exports/');
 define("EXPORTS_URL",SITE_URL.'exports/');

//Db settings
 define('DB_SERVER','localhost');
 define('DB_USER','root');
 define('DB_PASS' ,'1234567890');
 define('DB_NAME', 'rocky_sendright_campaign');


 define('EMAIL_SMTP','smtp address');
 define('EMAIL_PASS' ,'email address password');
 define('EMAIL_ADDRESS', 'email address ');


//for check used in demo or not
 define('IS_DEMO', false);



} else {
 //main variables
//print " host " . $_SERVER[HTTP_HOST];
 define("SITE_URL", 'http://'.$_SERVER['HTTP_HOST']. '/extension/campaign/');



 define("SITE_DIRECTORY",$_SERVER['DOCUMENT_ROOT'] . '/extension/campaign/');

 //elements.json file directory
 define("ELEMENTS_DIRECTORY",SITE_DIRECTORY.'elements.json');

 //uploads directory,url
 define("UPLOADS_DIRECTORY",SITE_DIRECTORY.'uploads/');


 define("UPLOADS_URL",SITE_URL.'uploads/');

//EXPORTS directory,url
 define("EXPORTS_DIRECTORY",SITE_DIRECTORY.'exports/');
 define("EXPORTS_URL",SITE_URL.'exports/');

//Db settings
 define('DB_SERVER','localhost');
 define('DB_USER','root');
 define('DB_PASS' ,'1234567890');
 define('DB_NAME', 'rocky_sendright_campaign');


 define('EMAIL_SMTP','smtp address');
 define('EMAIL_PASS' ,'email address password');
 define('EMAIL_ADDRESS', 'email address ');


//for check used in demo or not
 define('IS_DEMO', false);
}







?>
