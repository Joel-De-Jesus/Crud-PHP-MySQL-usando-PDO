<!DOCTYPE html>
<?php
require_once ('classPessoa.php');
$dados = new classPessoa("dados","localhost","root","");
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="pt-PT">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Joel De Jesus">
        <meta name="description" content="Improving my knowledge in PHP, HTML, and CSS">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="CSS/style.css">
        <title>CRUD PDO OO</title>
    </head>
    <body>
        <?php
            if(isset($_POST['nome']))//Se clicado os botoes cadastrar ou editar
            {
                //==============Botao Editar==================
                if(isset($_GET['id_update']) && !empty($_GET['id_update']))
                {
                    $id = htmlentities(addslashes($_GET['id_update']));
                    $nome = htmlentities(addslashes($_POST['nome']));
                    $telefone = htmlentities(addslashes($_POST['telefone']));
                    $email = htmlentities(addslashes($_POST['email']));

                    if(!empty($nome) && !empty($telefone) && !empty($email))
                    {
                        //Editar
                        $dados->update($nome, $telefone, $email, $id);
                        header("location: index.php");
                    }
                    else
                    {
                        ?>
                        <div class="aviso">
                            <img src="joel-pic.png">
                            <h4>Preencha todos os campos!</h4>
                        </div>
                        <?php
                    }
                }
                //===================Botao Cadastrar===============
                else
                    {
                        $nome = htmlentities(addslashes($_POST['nome']));
                        $telefone = htmlentities(addslashes($_POST['telefone']));
                        $email = htmlentities(addslashes($_POST['email']));

                        if(!empty($nome) && !empty($telefone) && !empty($email))
                        {
                            //Cadastrar
                            if(!$dados->insert($nome, $telefone, $email))
                            {
                                ?>
                                <div class="aviso">
                                    <img src="joel-pic.png">
                                    <h4>Email já está cadastrado!</h4>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div class="aviso">
                                <img src="joel-pic.png">
                                <h4>Preencha todos os campos!</h4>
                            </div>
                            <?php
                        }
                    }
            }
            
        if(isset($_GET['id_update']))//Se clicado no botao editar
        {
            $id_update = htmlentities(addslashes($_GET['id_update']));
            $update = $dados->buscarDados($id_update);
        }
        ?>
        <section id="left">
            <form method="POST">
                <h1>Cadastrar Pessoa</h1>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome"
                       value="<?php if(isset($update)){
                        echo $update['nome'];}?>">
                <label for="telefone">Telefone</label>
                <input type="number" name="telefone" id="telefone"
                       value="<?php if(isset($update)){
                        echo $update['telefone'];}?>">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       value="<?php if(isset($update)){
                        echo $update['email'];}?>">
                <input type="submit" value="<?php if(isset($update)){
                        echo "Actualizar";}else{echo "Cadastrar";}?>">
            </form>
        </section>
        <section id="right">
            <table>
            <tr id="header">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>
            <?php
                $result = $dados->select();
                if(count($result)>0)
                {
                    for ($i = 0; $i < count($result); $i++) {
                        echo "<tr>";
                        foreach ($result[$i] as $key => $value) {
                            if($key != "id")
                            {
                                echo "<td>".$value."</td>";
                            }
                        }
                        ?>
                            <td>
                                <a href="index.php?id_update=<?php echo $result[$i]['id'];?>">Editar</a>
                                <a href="index.php?id=<?php echo $result[$i]['id'];?>">Excluir</a>
                            </td>
                        <?php
                        echo "</tr>";
                    }
                }
        else
        {
        ?>
            </table>
            <div class="aviso">
                <h4>Ainda não há pessoas cadastradas!</h4>
            </div>
            <?php
        }
        ?>
        </section>
    </body>
</html>

<?php
    if(isset($_GET['id']))
    {
        $id = htmlentities(addslashes($_GET['id']));
        $dados->delete($id);
        header("location: index.php");
    }
?>