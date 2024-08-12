<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Import jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Import Boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Use Global CSS -->
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <div id="content">
    </div>
</body>

<script>
    $(document).ready(function () {
        // Function to get query string parameter
        function getQueryParam(param) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Check if the 'page' query parameter is set to 'home'
        var page = getQueryParam('page');
        var data = getQueryParam('data');
        if (page === 'login') {
            // Include the Home page content
            $('#content').load('page/login.php');
        } else if (page === 'logout') {
            $('#content').load('page/logout.php');
        } else if (page === 'profile') {
            $('#content').load('page/profile.php');
        } else if (page === 'find') {
            $('#content').load('page/find.php');
        } else if (page === 'home') {
            $('#content').load('page/home.php');
        } else if (page === 'hire') {
            $('#content').load('page/hire.php');
        } else {
            $('#content').load('page/home.php');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="https://static.line-scdn.net/liff/edge/versions/2.9.0/sdk.js"></script>
<script src="js/main.js"></script>

</html>