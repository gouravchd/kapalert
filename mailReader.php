<?php
set_time_limit(-1);
$imapPath = '{secure213.sgcpanel.com:143}INBOX';
$username = 'xxx@xxx.com';
$password = '*********';
$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Host: ' . imap_last_error());
// $emails = imap_search($inbox,'SUBJECT "Allip_43" ON "'.date("j F Y").'"');
$emails = imap_search($inbox,'UNSEEN SUBJECT "Allip_43"');
if($emails){
	foreach($emails as $mail) {
		$headerInfo = imap_headerinfo($inbox,$mail);
		$find = glob("faults/".imap_utf8($headerInfo->subject).'.txt');
		if(count($find)==0){
			$message = imap_fetchbody($inbox,$mail,1);
			$fp = fopen("faults/".imap_utf8($headerInfo->subject).".txt","wb");
			fwrite($fp,$message);
			fclose($fp);
		}
	}
	imap_expunge($inbox);
	imap_close($inbox);
}
?>
