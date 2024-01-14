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

    <script src="./scripts/searchdata.js"></script>
    <link href="styles/home.css" rel="stylesheet"> <!-- Incluir seu arquivo CSS -->
    link
</head>
 
<body>
    <div>
        <header>
            <div class="container-top">
                <a href="./index.php?user=<?php echo $_GET['user'];?>"><img src="./images/Logotipo_RMS.png" alt="Logotipo RMS" class="ghostWhite"> </a>
                
                <h1>Biblioteca de Informações de Backups</h1><br>
                <?php echo 'Bem Vindo ' . $_SESSION['nome_login']; ?> 
                <a href="logout.php"><button class="btn-danger">Sair</button></a>
            </div>
        </header>
 
        <main>
            <div class="container-form">
                <div>
                    <input class="input-search" type="search" onkeyup="get_element_info('searchData',this.value,'','','corpoTabela');" name="nome" id="nome" placeholder="Pesquisar">

                    <!-- <button name="pesquisar" onclick="searchData()"><i class="fa-solid fa-magnifying-glass"></i></button> -->
                    <button class="mostrar-modal-botao"id="mostrar-modal-botao">Adicionar</button>
                </div>
                <br>
                <div class="modal" id="modal">
                    <form id="form" method="POST" action="">
                        <div class="div-titulo-modal"><label id="titulo-modal"for="">Registro de Dados</label></div>
                        <div class="div-input-nome">
                            <label for="nomeModal">Nome:</label>
                            <input class="input-modal-nome" type="text" id="nomeModal" name="nome" required><br><br>
                        </div>
                        <div class="div-input-date-hd">
                            <label for="data">Data:</label>
                            <input class="input-modal-data" type="date" id="data" name="data_bkp" required>
                            <label for="hd">HD:</label>
                            <input class="input-modal-hd" type="text" id="hd" name="hd" required>
                        </div>
                        <div class="div-select">
                            <label for="cargo">Cargo:</label>
                            <select name="cargo" id="cargo" required>
                                <option value="" selected> ------------</option>
                                <option value="Funcioário(a)">Funcionário(a)</option>
                                <option value="Advogado(a)">Advogado(a)</option>
                                <option value="JovemAprendiz">Jovem Aprendiz</option>
                                <option value="Estagiário(a)">Estagiário(a)</option>
                                <option value="Outros">Outros</option>
                            </select>
                            
                        </div>
                        <div class="div-btn-modal">
                            <input class="enviar" type="submit" name="submit" id="submit">
                            <button class="cancelar"id="closeModal">Cancelar</button>
                        </div>
                    
                    
                    </form>
                    
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CARGO</th>
                            <th>DATA</th>
                            <th>HD</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="corpoTabela">
                        <?php 
                            
                            include_once('conexao.php');
                        
                            // $p = $_GET['p'];
                            // Verifica se a variável tá declarada, senão deixa na primeira página como padrão
                            $p = isset($_GET['p']) ? $_GET['p'] : 0;

                            // Verifica se 'p' está definido e se é um número válido
                            if (!is_numeric($p) || $p < 1) {
                                $p = 1; // Defina um valor padrão se 'p' não for válido
                            }
                            
                            // Defina aqui a quantidade máxima de registros por página.
                            $qnt = 10;
                            // O sistema calcula o início da seleção calculando: 
                            // (página atual * quantidade por página) - quantidade por página
                            $inicio = ($p*$qnt) - $qnt;
                            // Seleciona no banco de dados com o LIMIT indicado pelos números acima
                            $query = "SELECT * FROM registro_psts ORDER BY nome ASC LIMIT $inicio, $qnt ";

                            $result = mysqli_query($conexao, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {



	                if ($row['data_bkp']== "0000-00-00")
                        {
                                $databkp = " - ";
                        }else{
                                $databkp =  date('d/m/Y', strtotime($row['data_bkp']));
                        }

                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td align='left'>" . ucwords(strtolower($row['nome'])) . "</td>";
                                        echo "<td>" . ucwords($row['cargo']) . "</td>";
                                        echo "<td>" . $databkp . "</td>";
                                        echo "<td>" . intval($row['hd']) . "</td>";
                                        // echo "<td> 
                                        // <a class='btn btn-sm btn-primary' href='#' onclick='editarRegistro(" . $row['id'] . ")'>
                                        // <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        // <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                        // </svg>
                                        // </a>
                                        // </td>"; // Substitua por suas ações de edição/exclusão
                                        echo "</tr>";
                                    }
                                    
                                } else{
                                    echo '<tr><td colspan="5">Registro não encontrado.</td></tr>';
                                }
                                    echo '<tr><td colspan="6"><br><hr><br></td></tr>';
                            $queryAll = "SELECT * FROM registro_psts";
                            $result2 = mysqli_query($conexao, $queryAll);
                            $total_registros = mysqli_num_rows($result2);
                            $pags = ceil($total_registros/$qnt);
                            // Número máximos de botões de paginação
                            $max_links = 2;
                            // Cria um for() para exibir os 3 links antes da página atual
                            // Exibe a página atual, sem link, apenas o número
                            // Exibe o link "última página"
                            echo '<tr><td colspan="5">
                            <div class="pagination">';

                            if ($p>=4) {
                                echo '<ul><li id="previous" onclick="paginaAnterior()"><a href="home.php?p=1" target="_self">Primeira página</a></li></ul>';
                            } else{
                                echo '';
                            }

                           for($i = $p-$max_links; $i <= $p-1; $i++) {
                                // Se o número da página for menor ou igual a zero, não faz nada
                                // (afinal, não existe página 0, -1, -2..)
                                if($i <=0) {
                                    //faz nada
                                    // Se estiver tudo OK, cria o link para outra página
                                } 
                                else {
                                        $class = ($i == $p) ? 'active' : '';
                                        echo '<ul><li id="pagina" class="'.$class.'"><a href="home.php?p='.$i.'" target="_self">'.$i.'</a></li></ul>';
                                    }
                            }
                            // Botão da página atual com a classe "active"

                            echo '<ul><li id="pagina" class="active">'.$p.'</li></ul>';

                            // Cria outro for(), desta vez para exibir 3 links após a página atual
                            for($i = $p+1; $i <= $p+$max_links; $i++) {
                                // Verifica se a página atual é maior do que a última página. Se for, não faz nada.
                                if($i > $pags)
                                {
                                    //faz nada
                                }
                                // Se tiver tudo Ok gera os links.
                                else
                                {
                                    // Adiciona a classe "active" se a página for a atual
                                    $class = ($i == $p) ? 'active' : '';
                                    echo'<ul><li id="pagina" class="'.$class.'"><a href="home.php?p='.$i.'" target="_self">'.$i.'</a></li></ul>';
                                }
                            }

                            // echo'
                            // <ul><li id="last" onclick="irParaUltimaPagina()"><a href="home.php?p='.$pags.'" target="_self">Ultima página</a></li></ul>
                            // </div>
                            // </td></tr>';  
                            // $ult_p = $p + $max_links;
                            if ((($p + $max_links) >= $pags) || ($pags < 3)) {
                                echo "";   
                             } else{
                               
                               echo'
                            <ul><li id="last" onclick="irParaUltimaPagina()"><a href="home.php?p='.$pags.'" target="_self">Última página</a></li></ul>
                            </div>
                            </td></tr>';
                              } 
                        ?>
                    </tbody>
                </table>
            </div> 
        </main>
    </div>
<script src="./scripts/home.js"></script>

<script>
    var numero_de_paginas = <?= $numero_de_paginas ?>;
</script>

</body>
 
</html>
 
<?php
 
include_once('conexao.php');
 
    if(isset($_POST['submit']))
    {
        // include_once('conexao.php');
 
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $data = $_POST['data_bkp'];
        $hd = $_POST['hd'];
        $result = mysqli_query($conexao, "INSERT INTO registro_psts(nome, cargo, data_bkp, hd, data_hora_registro) VALUES ('$nome','$cargo','$data','$hd',NOW())");
        //$query = "INSERT INTO registro_psts (nome,data_bkp,hd) VALUES ('$nome','$data','$hd')";
        //$result = mysqli_query($conexao, $query);
 
        //if ($result) {
        //echo "Dados inseridos com sucesso!";
        //} else {
        //echo "Erro ao inserir dados: " . mysqli_error($conexao);
        //}
 
    }
 
?>
