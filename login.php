
<!-- Estrutura de autenticação LDAP -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iT-Sync | Login</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="shortcut icon" href="vader.ico" type="image/x-icon">
</head>
<body>
    <div class="login-container">
        <h1>iT.Sync</h1>
        <form class="login-form" action="loading.php" method="POST">
            <div class="form-group">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Entrar">
            </div>
            
        </form>
    </div>
    
    
</body>
</html>
