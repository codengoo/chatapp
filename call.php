<!DOCTYPE html>
<html>

<head>
    <title>Calling</title>
    <script src='https://8x8.vc/libs/external_api.min.js'></script>
    <link rel='stylesheet' href='./styles.css' />
</head>

<body>
    <div id="calling-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const domain = '8x8.vc';
            const options = {
                roomName: `<?php
                            require_once 'jwt.php';
                            echo getAppID() . htmlspecialchars($_GET["room"]);
                            ?>`,
                jwt: `<?php
                        require_once 'jwt.php';
                        echo createJWT()
                        ?>`,
                width: '100%',
                height: '100%',
                parentNode: document.querySelector('#calling-container')
            };
            const api = new JitsiMeetExternalAPI(domain, options);
        });
    </script>
</body>

</html>