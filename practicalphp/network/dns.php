<?php
    /*
	if (dns_check_record("snaps.php.net")) { print "Snaps.php.net exists\n"; }
    if (dns_check_record("kde.org")) { print "KDE.org exists\n"; }
    if (dns_check_record("fzzbcks.net")) { print "Fzzbcks.net exists\n"; }
	*/
	echo "<pre>";
    print_r(dns_get_record("www.semicolondev.com"));
	echo "</pre>";
?>