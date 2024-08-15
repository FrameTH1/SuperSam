<?php 
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout with LIFF</title>
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script>
        $(document).ready(function () {
            // Check if user is logged in
            liff.init({ liffId: "2005319575-G7VDXX62" }, () => {
                if (liff.isLoggedIn()) {
                    liff.logout();
                }
            })

            window.location = '?page=find'
        });
    </script>
</head>

</html>