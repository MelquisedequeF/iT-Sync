<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/loading.style.css">
    <title>Loading...</title>
    <?php
//echo $_SERVER['REQUEST_METHOD'];
//echo var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Dados de conexão com o servidor LDAP
    $ldapServer = 'localhost'; // Substitua pelo endereço do seu servidor AD
    $ldapPort = 389; // Porta LDAP padrão
    $ldapBaseDN = 'OU=TI,OU=EQUIPES,OU=MATRIZ,OU=RMS,DC=rochamarinho,DC=adv,DC=br'; // Substitua pelo Base DN do seu domínio
    $ldapUser = 'rochamarinho\\' . $_POST['username']; // Obtém o nome de usuário do formulário
    $ldapPass = $_POST['password']; // Obtém a senha do formulário


    // Tentar conectar ao servidor LDAP

    $ldapConn = ldap_connect($ldapServer, $ldapPort);
    


    if (!$ldapConn) {
        die('Erro na conexão com o servidor LDAP');
    }

    // Configurações adicionais, se necessário
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

    // Tente autenticar
    $ldapBind = @ldap_bind($ldapConn, $ldapUser, $ldapPass);

    if ($ldapBind) {
        // Verifique se o usuário pertence ao domínio
        $filter = "(sAMAccountName=" . $_POST['username'] . ")";
        $attributes = array("distinguishedName");
        $result = ldap_search($ldapConn, $ldapBaseDN, $filter, $attributes);
        $entries = ldap_get_entries($ldapConn, $result);

        if ($entries["count"] > 0) {
            //Iniciando a sessão:
            
            //Gravando valores dentro da sessão aberta:
            // $_SESSION['nome_usuario'] = 'Yure Pereira';
            $_SESSION['nome_login'] = $_POST['username'];

            $_SESSION['status'] = 'LOGADO';
            echo '<script>
            // Função para redirecionar após o atraso
            function redirecionar() {
                setTimeout(function() {
                    window.location.href = \'index.php?user='.$_POST['username'].'\'; 
                }, 2000); // 2000 milissegundos = 2 segundos
            }
        </script>
        </head>
        <body onload="redirecionar()">
            <div class="wrapper" >
                <span>RMS ADVOGADOS</span>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>
                <div class="shadow"></div>   
            </div>
        </body>
        </html>';
            // Realize ações após a autenticação bem-sucedida, se necessário
        } else {
            echo 'Usuário não pertence ao domínio desejado';
        }
    } else {
        echo '<script>alert (\'Credênciais invalidas\'); window.location.href = \'login.php\'; </script>';
        
        
    }

    // Fechar a conexão LDAP
    ldap_close($ldapConn);
}
?>
    


