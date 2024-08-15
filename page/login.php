<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function runLiff() {
            liff.init({ liffId: "2005319575-G7VDXX62" }, () => {
                if (!liff.isLoggedIn({ scope: 'profile openid email' })) {
                    liff.login();
                } else {
                    runApp();
                }
            }, err => console.error(err.code, err.message));
        }

        function runApp() {
            liff.getProfile().then(profile => {
                checkAndRedirect(profile.userId, profile.displayName, profile.statusMessage, profile.pictureUrl, liff.getDecodedIDToken().email);
            }).catch(err => console.error(err));
        }

        function checkAndRedirect(userId, displayName, statusMessage, pictureUrl, email) {
            var formData = new FormData();
            formData.append('userId', userId);
            formData.append('displayName', displayName);
            formData.append('statusMessage', statusMessage);
            formData.append('pictureUrl', pictureUrl);
            formData.append('email', email);

            fetch('action/check_user.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        window.location.href = '?page=find';
                    } else {
                        alert('User not found. Added now.');
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        runLiff();
    </script>

    <script src="js/main.js"></script>
</head>

</html>