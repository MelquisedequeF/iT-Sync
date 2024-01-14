<?php
//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
  //Acessando valores dentro de uma sessão:
  //echo var_dump($_SESSION);
  
  
  if (!isset($_SESSION['status'] )) {
  
      echo'<script>alert (\'Você não está logado, seu fela!!!\');
              window.location.href = \'login.php\'; 
  </script>';
  }
  
// Inicia a sessão
// session_start();

// Define o tempo limite da sessão em segundos (por exemplo, 30 minutos)
$session_timeout = 1800;

// Verifica se a última atividade do usuário está além do tempo limite
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // A sessão expirou; destrua a sessão e redirecione para a página de login
    session_unset();
    session_destroy();
    
    echo '<script>alert(\'Sua sessão expirou. Você será redirecionado para a página de login.\');
              window.location.href = \'login.php\'; 
          </script>';
    exit();
    
}

// Atualiza o tempo da última atividade
$_SESSION['last_activity'] = time();


?>
<script>
        // Atualiza a página automaticamente após o tempo limite da sessão
        setTimeout(function () {
            location.reload();
        }, <?php echo $session_timeout * 1000; ?>); // Multiplicando por 1000 para converter segundos em milissegundos
    </script>
