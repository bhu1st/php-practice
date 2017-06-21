<?php
    
	//There are three functions designed to specifically resolve web host information, and these are gethostbyaddr(), gethostbyname() and gethostbynamel() (that is a lower-case L, by the way). All three take one parameter, and the first two complement each other perfectly - gethostbyname() returns the IP address of a server you specify, and gethostbyaddr() returns the domain name of an IP address you specify. Here is an example of their usage:
	echo "<pre>";
	$sdip = gethostbyname("slashdot.org");
    $sddomain = gethostbyaddr($sdip);
    print "IP: $sdip\n";
    print "Domain: $sddomain\n";
	
	//By default, gethostbyname() returns the first value IP address for a host, but it is possible that one host has several. This is particularly common for large websites such as microsoft.com, where the site load is typically distributed across seven or eight web servers. If you want more detailed information about all the IP addresses backing a site, use gethostbynamel(), 
	
	$msips = gethostbynamel("www.microsoft.com");    
	var_dump($msips);
	
?>