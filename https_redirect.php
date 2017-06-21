<?

if($_SERVER['HTTPS']!="on")
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location:$redirect");
  }
  
  ?>
  
  
PHP HTTPS creation?
Hello

I'm an intermediate PHP developer and so far all the projects I've worked on were pretty small so I never found the need to incorporate SSL functionality to the application. Okay so now I need to create a login page with HTTPS. My question is:

1. Do I need to write any extra code to make the page HTTPS?
2. If so then are there any resources you can recommend where I can learn to make a very simple HTTPS login page?
3. If not then is the browser responsible for making the SSL validations?
4. Do I need to make any changes to my (Linux) server?
Any help would be greatly appreciated. Thanks in advance.


Answer:

1) No. Long time ago I think around 1997 you had to be phps or something like that. Nowadays HTTS validation is done one a server part. There are literally no changes on the programming code (I have set up couple large systems on Apache/PHP and Oracle one before my current for 7,000 users around US)

2. Nothing on a PHP side you need to learn. Everything goes regular way all scripts are taken care the same way (POST form, etc). HTTPS is a different layer of netwrok than your programming, so once again no changes required.

3. The browsers sees you are using https and it talks on port 443 (80 http, 443 https), the valid certificate has to be found on server side (looke point 4.)

4. you did not say what you are using for webserver. Apache? Whatever it is, you have to have a valid certificate. Your own you can generate using OpenSSL (google for that software) it is a Key that you are generating and putting into your server configuration file. However, you as a person are not trust certification centre, so before anything under HTTPS will be shown up, the window will come with information: valid certificate: yes, valid domain: yes, valid authority for SSL key: no. And it will ask user to go inside. You have to buy a certificate from 3rd party company that is trust, such as Thafte, Verisign, and the one I got many keys from and works like charm (they all work the same it is a price I am talking about): http://www.rapidssl.com.
Keep in mind you still have to generate your private key (suing OpenSSL) and send it to them that they will generate a public one. Very important tip: make sure domain you are entering using SSL _match_ domain you will be using your key with. Each SSL certificate comes either for a certain full domain name such as secure.mysite.com, or it can also came in a wildcard, such as *.mysite.com. Obvious advantage of wildcard is you need just a one key that will work for any https under mysite.com. Of course it is more expensive than one chosen for a cetain name such as secure.mysite.com. 
Another tip: any company that you request a key from will send that key back JUST on a email address that has been assigned to that certain domain. If you register your domain with joe.smith@yahoo.com they will check that in domain record and tell you that certificate key will be sent to that certain address you have registered your domain with. You may have some troubles getting them to send it anywhere else, so make sure you are receiving emails from the address you have registered domain with.

Hopes that fill you in.
For testing purposes, I would just generate my own key and click "yes trust" everytime browser ask me to use https. Obviously for a real life system you dont want to confuse users with any question just they hit https and golden lock will show up.

Good luck!


Answer:


>> 1. Do I need to write any extra code to make the page HTTPS?

You can always query the server variables for the HTTPS value; if the page is being accessed via HTTPS, the variable will return a non-empty value:

<?php
//if not on HTTPS
if(empty($_SERVER['HTTPS'])) {
//build link to https page; protocol, server and current script path
$url = "Location: https://www.server.com/" . __FILE__;
//addy querystring, if appropriate
if(count($_GET) != 0) {
$url .= "?";
foreach($_GET as $key => $value) {
$url .= "$key=$value&";
}
}
//send permanent move redirect
header($url, true, 301);
}
?>

Note that this sends a header, so you need to use this script before any output is sent to the client (that is, add this script to the very top of the page). 

This should work for 99 percent of servers. 

If it doesn't work, generally speaking, Web servers handle HTTPS requests on port 443. So, if you simply check the server variables for the port, and redirect if the port is not 443, that will switch the user to an https connection.

<?php
if($_SERVER['SERVER_PORT'] != 443) {
//code for redirecting to https connection
}
?>

>> 2. If so then are there any resources you can recommend where I can learn to make a very simple HTTPS login page?

Any old login script should work. HTTPS is just the transportation protocol for the packets; PHP doesn't really care how the information gets to it, it just cares about getting the information.

>> 3. If not then is the browser responsible for making the SSL validations?

All SSL certificates are validated at the client-server-authority level. It has nothing to do with PHP.

>> 4. Do I need to make any changes to my (Linux) server?

Assuming you have properly installed your certificate, no.
