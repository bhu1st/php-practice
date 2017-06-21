<?php
//http
/*    $fp = fsockopen ("slashdot.org", 80);

    if ($fp) {
        fwrite($fp, "GET / HTTP/1.1\r\nHOST: slashdot.org\r\n\r\n");

        while (!feof($fp)) {
            print fread($fp,256);
        }

        fclose ($fp);
    } else {
        print "Fatal error\n";
    }
	*/

	//whois
    $fp = fsockopen ("whois.networksolutions.com", 43);

    if ($fp) {
        fwrite($fp, "microsoft.com\n");

        while (!feof($fp)) {
            print fread($fp,256);
        }

        fclose ($fp);
    } else {
        print"Fatal error\n";
    }
?>

