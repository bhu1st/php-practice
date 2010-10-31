<?php
    $conn = ftp_connect("ftp.gnu.org");
    ftp_login($conn, "anonymous", "foo@bar.com");
    ftp_pasv($conn, true);
    ftp_chdir($conn, "/gnu/bash");

    $files = ftp_nlist($conn, ".");
    srand ((float)microtime()*1000000);
    shuffle($files);
	print_r($files);

    $filetoget = array_pop($files);
    ftp_get($conn, $filetoget, $filetoget, FTP_BINARY);
    ftp_close($conn);
?>