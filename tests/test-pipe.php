#!/usr/bin/php -q
<?php    
$sock = fopen ("php://stdin", 'r');
$email = ''; 
//Read e-mail into buffer
while (!feof($sock))
{
    $email .= fread($sock, 1024);
} 
//Close socket
fclose($sock); 
//Assumes $email contains the contents of the e-mail
//When the script is done, $subject, $to, $message, and $from all contain appropriate values 
$subject1 = explode ("\nSubject: ", $email);
$subject2 = explode ("\n", $subject1[1]);
$subject = $subject2[0]; 
$to1 = explode ("\nTo: ", $email);
$to2 = explode ("\n", $to1[1]);
$to = str_replace ('>', '', str_replace('<', '', $to2[0])); 
$message1 = explode ("\n\n", $email); 
$start = count ($message1) - 3; 
if ($start < 1)
{
    $start = 1;
} 
//Parse "message"
$message2 = explode ("\n\n", $message1[$start]);
$message = $message2[0]; 
//Parse "from"
$from1 = explode ("\nFrom: ", $email);
$from2 = explode ("\n", $from1[1]); 
if(strpos ($from2[0], '<') !== false)
{
    $from3 = explode ('<', $from2[0]);
    $from4 = explode ('>', $from3[1]);
    $from = $from4[0];  

    $fromIndex0 = $from2[0]; 
    $fromName = $from3[0];  
}
else
{
    $from = $from2[0];
}   

// recent sent email record to a file
$myfile = fopen("/home/iamroc5/public_html/sendright/tests/newfile.txt", "w") or die("Unable to open file(filename)!");
$txt = " nowww 1 to    $to  email subject  $subject   from   $from  fromindex0 $fromIndex0 from name $fromName   \n email $email   message \n\n\n $message  ";
fwrite($myfile, $txt); 
fclose($myfile);



