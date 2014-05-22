BTC-Split-Script
======================

A simple PHP script to split Bitcoin transactions using a Blockchain.info account

Download Now

[![Download Now as ZIP!](http://i.imgur.com/ZDBKiSa.gif "Download Now as ZIP!")](https://github.com/Initscri/BTC-Split-Script--PHP-/archive/master.zip)

Installation and Setup
----------------------

Please note, the following setup instructions were copied and pasted from the person originally requesting this script, and may not work for all use cases.

First, you must get a server of some sorts. 

I wouldn't recommend a simple webhosting account. It can be insecure especially if dealing with large amounts of funds.

This can be a $1 vps at http:/lowendbox.com/ or your computer at home (As long as it can be access on the net -> port forwarded).

If you want to benefit me, you can tell me a provider and I can give an affiliate key, but that's optional.

I would recommend getting a vps or hosting locally.

If you get a vps, setup apache2 (for Ubuntu) or for centos, use httpd. Also install php (pref. ver 5)
Follow this guide: http://www.howtoforge.com/ubuntu_lamp_for_newbies
You can skip the MySQL part.
If you need help with this, let me know.

If you do it locally:
Download http://www.wampserver.com/en/
Run it and install it.
Go to your router and port forward port 80 to your computer.
Info at http://portforward.com/
If you have a dynamic ip, you should look into:
http://www.noip.com/

Copy and paste the script to a file called "btc_split_script.php" in the directory provided by your server software.

Once you have a script setup, copy the file "btc_split_script.php" into your root directory.

Save the script and $callback_key to a random string. Don't make it too long, but don't make it too little.

Go to http://blockchain.info/ and sign up for a new wallet.
You will get a guid which is the login.
You will also make a password, that is your first password.

Once into the wallet, go to "Account Settings" on the right side, Click Continue on Sensitive Data, and click on "Passwords". Scroll down to "Second Password", create a secure password and set $secondpassword to it. Click "Enable Double Encryption"

Save the script. You can define your addresses later.

ON Blockchain.info Click on "Notifications" and create a new HTTP Notification.
Fill it with "http://yourdomain.com-or-ip/btc_split_script.php?callback_key=put-$callback_key-here"

So for example, it could be...
http://mydomain.com/btc_split_script.php?callback_key=89say9d8gsauiodgsa6d7gw1iuegsayid
or
http://10.0.0.0/btc_split_script.php?callback_key=89say9d8gsauiodgsa6d7gw1iuegsayid

Optional: Change "When My Wallet" to receiving only. (The script will ignore sending transactions, but it's better for your server).

Copy the main address for the account.
Go back into btc_split_script.php and edit the $recipients variable in the format
"address" => percentage_number, // <- must be comma
Just follow the way it is now.

Once you click save, you can close everything down.
Send a dollar or so to the address to confirm it is working correctly before sending larger transactions.

Good Luck

Please see license for licensing details.
