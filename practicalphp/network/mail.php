<?php
    
	/*
	$mailtoname = "My Best Friend";
    $mailtoaddress = "fren4fun@gmail.com";
    $mailtocomplete = "$mailtoname <$mailtoaddress>";
    mail($mailtocomplete, "My Subject", "Hello, world!");
	*/
	
	$message = "<B>This is a <I>test</I></B>";
    $headers = "From: foo@bar.com\r\nContent-type: text/html\r\n";
    mail("fren4fun@gmail.com", "Testing", $message, $headers);
	
	/*
	$mailto = "My Best Friend <best@friend.com>";
    $mailfrom = "Joe Bloggs <joe@bloggs.org>";
    $mailcc = "My Best Friend2 <best@friend2.com>";
    $mailbcc = "My Best Friend3 <best@friend3.com>";
    mail($mailto, "My Subject", "Hello, world!", "From: $mailfrom\r\nCC: $mailcc\r\nBCC: $mailbcc\r\n");
	*/
?>