<?php
// include_once('session.php');

include_once('conexao.php');

$op		=	(isset($_GET['op']))	?	$_GET['op']		:	"";
$pid	=	(isset($_GET['pid']))	?	$_GET['pid']	:	"";
$arg1	=	(isset($_GET['arg1']))	?	$_GET['arg1']	:	"";
$arg2	=	(isset($_GET['arg2']))	?	$_GET['arg2']	:	"";
$arg3	=	(isset($_GET['arg3']))	?	$_GET['arg3']	:	"";
//$arg4	=	(isset($_GET['arg4']))	?	$_GET['arg4']	:	"";
//$arg5	=	(isset($_GET['arg5']))	?	$_GET['arg5']	:	"";
//$arg6	=	(isset($_GET['arg6']))	?	$_GET['arg6']	:	"";
//$arg7	=	(isset($_GET['arg7']))	?	$_GET['arg7']	:	"";
//$arg8	=	(isset($_GET['arg8']))	?	$_GET['arg8']	:	"";

//SELECT convenios COmissões ADMIN
if ($op == "searchData"){
    //echo $arg1."</> ";
    //echo $arg2."</> ";
    //echo $arg3."</>";

        // $p = $_GET['p'];
        // Verifica se a variável tá declarada, senão deixa na primeira página como padrão
        $p = isset($arg2) ? $arg2 : 0;

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
        $query = "SELECT * FROM registro_psts WHERE nome LIKE '%$arg1%' OR CAST(hd AS SIGNED) = " . intval($arg1) . " LIMIT $inicio, $qnt";


        $result = $conexao->query($query);
        if (!$result) {
            die('Erro na consulta SQL: ' . $conexao->error);
        }
        // Exibição dos resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
		if($row['data_bkp']== "0000-00-00")
			{
				$data = " - ";
			}else{
				$data =  date('d/m/Y', strtotime($row['data_bkp']));
			}

                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td align='left'>" . ucwords(strtolower($row['nome'])) . "</td>";
                echo "<td align='left'>" . ucwords(strtolower($row['cargo'])) . "</td>";
                echo "<td>" . $data . "</td>";
                echo "<td>" . intval($row['hd']) . "</td>";
                echo "<td> 
                <a class='btn btn-sm btn-primary' href='#' onclick='editarRegistro(" . $row['id'] . ")'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                </svg>
                </a>
                </td>"; // Substitua por suas ações de edição/exclusão
                echo "</tr>";
            }
        } else {
            echo '<tr><td colspan="5">Registro não encontrado.</td></tr>';
        }

            echo '<tr><td colspan="6"><br><hr><br></td></tr>';
        $queryAll = "SELECT * FROM registro_psts WHERE nome LIKE '%$arg1%' OR CAST(hd AS SIGNED) = " . intval($arg1) . " LIMIT $inicio, $qnt";
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

        if ($p > 3) {
            echo '<ul><li id="previous"><a  href="#" onClick="get_element_info(\'searchData\',\''.$arg1.'\',\'1\',\'\',\'corpoTabela\');">Primeira página</a> </li></ul>';
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
                    echo '<ul><li id="pagina" class="'.$class.'"><a href="#" onClick="get_element_info(\'searchData\',\''.$arg1.'\',\''.$i.'\',\'\',\'corpoTabela\');"  target="_self">'.$i.'</a></li></ul> ';
                }
        }
            
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
                $class = ($i == $p) ? 'active' : '';
                echo'<ul><li id="pagina" class="'.$class.'"><a href="#" onClick="get_element_info(\'searchData\',\''.$arg1.'\',\''.$i.'\',\'\',\'corpoTabela\');"  target="_self">'.$i.'</a></li></ul> ';
            }
        }


        if (($pags == $p) || ($pags < 3)) {
          echo "";   
       } else{
         echo '<ul><li id="last"><a  href="#" onClick="get_element_info(\'searchData\',\''.$arg1.'\',\''.$pags.'\',\'\',\'corpoTabela\');">Última página</a> </li></ul>';
        }

        echo'
        </div>
        </td></tr>';   
    
}




// Fechar conexão com o banco de dados
$conexao->close();
?>
