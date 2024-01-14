<?php
session_start();
// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Certifique-se de que todas as informações de sessão são removidas do cliente
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redireciona para a tela de login
echo '<script>
        alert(\'Até logo! Sessão encerrada.\');
        window.location.href = \'login.php\'; 
      </script>';

?>