<?php
	//do not run this script.
	//this is for illustration

    print imap_open("{mail.yourserver.com:143}INBOX", "username", "password");
	//ms-exchange server
	//"{mail.yourserver.com:143/imap}Inbox"
	//username: "<yourdomain>/<yourusername>"
	 
	 //if you are running your IMAP server using SSL, you may need to use 
	 //"{mail.yourserver.com:993/ssl/novalidate-cert}INBOX"
	 
	 /* use server IP addresses */
	$imap = imap_open("{mail.yourserver.com:143}INBOX", "username", "password");
    imap_close($imap);
	
	

    $imap = imap_open("{mail.yourserver.com:143}INBOX", "username", "password");
    $header = imap_header($imap, 250);
    print_r($header);
    imap_close($imap);

	
	//reading mail information
	 $imap = imap_open("{mail.yourserver.com:143}INBOX", "username", "password");
    $message_count = imap_num_msg($imap);

    for ($i = 1; $i <= $message_count; ++$i) {
        $header = imap_header($imap, $i);
        $body = trim(substr(imap_body($imap, $i), 0, 100));
        $prettydate = date("jS F Y", $header->udate);

        if (isset($header->from[0]->personal)) {
            $personal = $header->from[0]->personal;
        } else {
            $personal = $header->from[0]->mailbox;
        }

        $email = "$personal <{$header->from[0]->mailbox}@{$header->from[0]->host}>";
        echo "On $prettydate, $email said \"$body\".\n";
    }

    imap_close($imap);

?>