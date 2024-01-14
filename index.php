<?php
include_once('session.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"> <!-- import FontAwesome -->
    <title>RMS Backups</title>
    <link href="./styles/index.css" rel="stylesheet"> <!-- Incluir seu arquivo CSS -->
</head>
<body>
    <div class="container">
        <header>
            <div class="container-top">
                <img src="./images/Logotipo_RMS.png" alt="Logotipo RMS" class="ghostWhite">
                <h1>Sistemas de Busca - RMS</h1>
            </div>
        </header>

        <main>
            <div class="container-button-bkp">
                <a href="./home.php?user=<?php echo $_GET['user'];?>"><img src="images/pst.jpg" alt=""></a>
            </div>

            <div class="container-button-history">
                <a href="registros_pcs.php?user=<?php echo $_GET['user'];?>"><img src="images/pc.jpg" alt=""></a>
            </div>
        </main>
    </div>

    <footer>
        <p>Copyright © 2023 - RMS Advogados - Suporte TI</p>
    </footer>
</body>
</html>
