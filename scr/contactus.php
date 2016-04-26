<!DOCTYPE HTML PUBLIC>

<html>

    <head>
        <title>Contact Us</title>
    </head>

    <body>

        <?php

            $customer_email = $_POST["customer_email"];
            $message = $_POST["message"];
            $reply_wanted = false;

            if (isset($_POST["reply_wanted"])) $reply_wanted = true;

            $t = "You have received a message from " . $customer_email . " :\n";
            $t = $t . $message . "\n";
            if ($reply_wanted)
                $t =  $t . "A reply was requested";
            else
                $t = $t . "No reply was requested";

            mail("hubert.zajac@outlook.com", "Customer Message", $t);

            echo "Than you. Your message has been sent";

        ?>


    </body>

</html>