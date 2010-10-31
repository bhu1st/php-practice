<?php
/*
1.Initialise Curl

2.Set URL we want to load

3.Retrieve and print the URL

4.Close Curl
*/
	/*
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://www.php.net");
    curl_exec ($curl);
    curl_close ($curl);
	*/
	
	//Passing CURLOPT_RETURNTRANSFER to curl_setopt() as parameter two and 1 as parameter three will force Curl not to print out the results of its query. Instead, it will return the results as a string return value from curl_exec() instead of the usual true/false. Note that if there is an error, false will still be the return value from curl_exec().
	/*
	$curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://www.php.net");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    print $result;
	*/
	
	//That script will output the same as the previous script, but having the web page stored in a variable before printing gives us more flexibility - we could have manipulated the data in any number of ways before printing.
	//Storing data in a variable is fine, but it would be much better to store it in a file, right? While we could achieve this using the file_put_contents() function, yet again Curl has an option to do the work for us. This time it is CURLOPT_FILE, which takes a file handle as its third parameter. We looked at file handles earlier, and it works the same here - we will use fopen() to open a file as writeable. Therefore, this time the script looks like this:

	/*
    $curl = curl_init();
    $fp = fopen("somefile.txt", "w");
    curl_setopt ($curl, CURLOPT_URL, "http://www.php.net");
    curl_setopt($curl, CURLOPT_FILE, $fp);

    curl_exec ($curl);
    curl_close ($curl);
	*/
	
	//FTP
	//Our next basic script is going to switch from HTTP to FTP so you can see how little difference there is. This next script connects to the GNU FTP server and gets a listing of the root directory there:
	/*
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"ftp://ftp.gnu.org");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    echo "<pre>";
	print $result;
	*/
	/*
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"ftp://ftp.gnu.org");
    curl_setopt($curl, CURLOPT_FTPLISTONLY, 1);//no read/write information
    curl_setopt($curl, CURLOPT_USERPWD, "anonymous:your@email.com"); //username and password used for logging in
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    print $result;
	*/
	
	//Try changing the username and password to random values, as this will cause the login to fail. If you run the script again, you will see nothing is printed out - no errors, no warnings; nothing. This is because Curl fails silently, and you need to request Curl's error message explicitly using curl_error(). 
	/*
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"ftp://ftp.gnu.org");
    curl_setopt($curl, CURLOPT_FTPLISTONLY, 1);
    curl_setopt($curl, CURLOPT_USERPWD, "foo:barbaz");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);// curl fails silently
    echo curl_error($curl); //displays errors
    curl_close ($curl);
    print $result;
	*/
	
	//The two new values, CURLOPT_POST and CURLOPT_POSTFIELDS, make our session prepare to send data over HTTP post and assign the data to send respectively
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"http://localhost/opensource/network/curl_post_test.php");
    curl_setopt($curl, CURLOPT_POST, 1);// CURLOPT_POST just takes a 1 to enable to POST usage
    curl_setopt($curl, CURLOPT_POSTFIELDS, "Hello=World&Foo=Bar&Baz=Wombat");//needs a properly formatted data string to send.
	//use 	urlencode($dataStr) here to avoid unnecessery spaces & special chareacters

    curl_exec ($curl);
    curl_close ($curl);
	
?>