<?php
    $socket = @socket_create_listen("12345");

    if (!$socket) {
        print "Failed to create socket!\n";
        exit;
    }

    while (true) {
        $client = socket_accept($socket);
        $welcome = "\nWelcome to the Amazing ROT13 Machine.\nType '!close' to close this connection, or type '!halt' to halt the server.\n";
        socket_write($client, $welcome);

        while (true) {
            $input = trim(socket_read ($client, 256));
            if ($input == '!close') {
                break;
            }

            if ($input == '!halt') {
                socket_close ($client);
                break 2;
            }

            $output = str_rot13($input) . "\n";
            socket_write($client, $output);
            print "Them: $input, Us: $output\n";
        }

        socket_close ($client);
    }

    socket_close ($socket);
?>