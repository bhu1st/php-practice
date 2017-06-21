<?php
    
	$socket = @socket_create_listen("8000");

    if (!$socket) {
        print "Failed to create socket!\n";
        exit;
    }else {
	echo "Server listening at: localhost:8000"."\n";
	}

    while (true) {
        $client = socket_accept($socket);
        $input = trim(socket_read ($client, 4096));
        $input = explode(" ", $input);
        $input = $input[1];
        $fileinfo = pathinfo($input);

        switch ($fileinfo['extension']) {
            case "png";
                $mime = "image/png";
                break;
            default:
                $mime = "text/html";
        }

        if ($input == "/") {
            $input = "/index.html";
        }

        $input = ".$input";

        if (file_exists($input) && is_readable($input)) {
            print "Serving $input\n";
            $contents = file_get_contents($input);
            $output = "HTTP/1.0 200 OK\r\nServer: APatchyServer\r\nConnection: close\r\nContent-Type: $mime\r\n\r\n$contents";
        } else {
            $contents = "The file you requested does not exist. Sorry!";
            $output = "HTTP/1.0 404 OBJECT NOT FOUND\r\nServer: APatchyServer\r\nConnection: close\r\nContent-Type: text/html\r\n\r\n$contents";
        }

        socket_write($client, $output);
        socket_close ($client);
    }

    socket_close ($socket);
?>