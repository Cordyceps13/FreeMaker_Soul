<?php
include 'configs.php';
$act = $_GET['act'];

/********************************************************************************************************************************************/
/*                                                                    REGISTER_USERS                                                        */
/********************************************************************************************************************************************/

switch ($act) {

    case 'register':

        $nickname = htmlentities($_POST['nickname']);
        $email = htmlentities($_POST['email']);
        $password = hash('sha256', SALT . $_POST['password'] . SALT);

        // Verificar se já existe alguma conta com este email ou nickname de utilizador 
        $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM utilizadores WHERE (email = ? or nickname = ?)');
        $stmt->bind_param('ss', $email, $nickname);
        $stmt->execute();
        $results = $stmt->get_result();
        $row = $results->fetch_assoc();

        if ($row['total'] !== 0) {
            header('Location: index.php?msg=ja_ha_registo');
            exit;
        }

        // Registar utilizador
        $stmt = $conn->prepare('INSERT INTO utilizadores (nickname, email, pw) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nickname, $email, $password);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            header('Location: index.php?msg=registo_error');
            exit;
        } else {
            header('Location: index.php?msg=registo_success');
        }

        break;


        /********************************************************************************************************************************************/
        /*                                                                   LOGIN                                                                  */
        /********************************************************************************************************************************************/

    case 'login':

        $email = htmlentities(strtolower($_POST['nickname']));
        $password = hash('sha256', SALT . $_POST['password'] . SALT);

        $stmt = $conn->prepare('SELECT ID, nickname, email, adm, pw FROM utilizadores WHERE (nickname = ? OR email = ?)');
        $stmt->bind_param('ss', $email, $email);
        $stmt->execute();
        $results = $stmt->get_result();
        $row = $results->fetch_assoc();


        if (!$row) {
            header('Location: index.php?msg=nao_ha_registo');
            exit;
        }


        if ($row['pw'] !== $password) {
            header('Location: index.php?msg=login_error');
            exit;
        }


        $row['email'] = strtolower($row['email']);
        $row['nickname'] = strtolower($row['nickname']);


        if (($row['nickname'] == $email || $row['email'] == $email) && $row['pw'] == $password) {
            $_SESSION['ID'] = $row['ID'];
            $_SESSION['nickname'] = $row['nickname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['adm'] = $row['adm'];

            header('Location: index.php?msg=login_success');
        }

        break;


        /********************************************************************************************************************************************/
        /*                                                                    LOGOUT                                                                */
        /********************************************************************************************************************************************/

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: index.php?msg=logout');
        break;

        /********************************************************************************************************************************************/
        /*                                                                   INSERT_PROD                                                            */
        /********************************************************************************************************************************************/

    case 'insert_product':

        $nome = htmlentities($_POST['nome_prod']);
        $descricao = htmlentities($_POST['descricao']);
        $preco = $_POST['preco'];
        $categoria = htmlentities($_POST['categoria']);
        $filamentos = $_POST['filamento'];
        $cores = $_POST['cor'];
        $utilizador = $_SESSION['ID'];


        $tudoOk = true;
        $conn->begin_transaction();

        $stmt = $conn->prepare('INSERT INTO produtos (nome, descricao, preco, ID_categoria, ID_utilizador) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssdii', $nome, $descricao, $preco, $categoria, $utilizador);
        $stmt->execute();

        $tudoOk &= $stmt->affected_rows !== 0;

        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Faltaram parâmetros na inserção do produto';
            $conn->rollback();
            header('Location: insert_prod.php?msg=error');
            exit;
        }

        $ID_produto = $conn->insert_id;

        $stmt = $conn->prepare('SELECT c.c_descricao FROM categorias AS c
                                JOIN produtos AS p ON p.ID_categoria = c.ID
                                WHERE p.ID = ?');

        $stmt->bind_param('i', $ID_produto);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $folder = 'imgs/produtos/' . $row['c_descricao'] . '/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if ($_FILES['foto']['name'][0]) {

            foreach ($_FILES['foto']['name'] as $key => $imagem) {
                $p_file = $_FILES['foto']['name'][$key];
                $extension = strtolower(pathinfo($p_file, PATHINFO_EXTENSION));

                if (!$tudoOk) {
                    $_SESSION['error_msg'] = 'Não foi possível adicionar foto';
                    break;
                }

                if (
                    $extension != 'jpg' &&
                    $extension != 'jpeg' &&
                    $extension != 'bmp' &&
                    $extension != 'png' &&
                    $extension != 'tiff' &&
                    $extension != 'gif'
                ) {
                    $_SESSION['error_msg'] = 'Ficheiro não permitido!!';
                }

                $imagem = uniqid() . '.' . $extension;

                move_uploaded_file($_FILES['foto']['tmp_name'][$key], $folder . $imagem);

                $stmt_img = $conn->prepare('INSERT INTO fotos (ID_produto, foto) VALUES (?, ?)');
                $stmt_img->bind_param('is', $ID_produto, $imagem);
                $stmt_img->execute();

                $tudoOk &= $stmt_img->affected_rows !== 0;
            }
        }

        $filamentos = array_filter($filamentos);
        $cores = array_filter($cores);

        if (!empty($filamentos) && !empty($cores)) {

            if (count($filamentos) === count($cores)) {

                $stmt_fil_cor = $conn->prepare('INSERT INTO produtos_filamentos_cores (ID_produto, ID_filamento, ID_cor) VALUES (?, ?, ?)');

                foreach ($filamentos as $key => $ID_filamento) {
                    if (!$tudoOk) {
                        $_SESSION['error_msg'] = 'Não foi possível associar filamentos e/ou cores';
                        break;
                    }

                    $ID_cor = $cores[$key];

                    $stmt_fil_cor->bind_param('iii', $ID_produto, $ID_filamento, $ID_cor);
                    $stmt_fil_cor->execute();

                    $tudoOk &= $stmt_fil_cor->affected_rows !== 0;
                }
            } else {
                $tudoOk = false;
            }
        } else {
            $tudoOk = false;
            $_SESSION['error_msg'] = 'Faltou associar filamento(s) e/ou cor(es)';
        }

        $tudoOk_STL = true;

        $folder = 'ficheiros_stl/';

        if ($_FILES['ficheiro']['name'][0]) {

            foreach ($_FILES['ficheiro']['name'] as $key => $ficheiro) {
                $stl_file = $_FILES['ficheiro']['name'][$key];
                $extension = strtolower(pathinfo($stl_file, PATHINFO_EXTENSION));

                if (!$tudoOk_STL) {
                    $_SESSION['error_msg'] = 'Não foi possível adicionar o ficheiro STL';
                    break;
                }

                if ($extension != 'stl')
                    $_SESSION['error_msg'] = 'Ficheiro não permitido!!';

                $ficheiro = uniqid() . '.' . $extension;

                move_uploaded_file($_FILES['ficheiro']['tmp_name'][$key], $folder . $ficheiro);

                $stmt_f = $conn->prepare('INSERT INTO ficheiros_stl (ID_produto, ficheiro) VALUES (?, ?)');
                $stmt_f->bind_param('is', $ID_produto, $ficheiro);
                $stmt_f->execute();

                $tudoOk_STL &= $stmt->affected_rows !== 0;
            }
        } else {
            $tudoOk_STL = false;
            $_SESSION['info_msg'] = 'Não foi introduzido nenhum ficheiro STL<br><br>
                                  Mas podes fazê-lo mais tarde na página de configurações ;)';
        }


        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Não foi possível introduzir o produto';
            $conn->rollback();
            header('Location: insert_prod.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'Produto adicionado com sucesso!';
            $conn->commit();
            header('Location: insert_prod.php?msg=success');
        }

        break;

        /********************************************************************************************************************************************/
        /*                                                                    SUGEST_PROD                                                           */
        /********************************************************************************************************************************************/

    case 'sugest_product':

        $nome = $_POST['nome_prod'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $utilizador = $_SESSION['ID'];

        $conn->begin_transaction();
        $tudoOk = true;

        $tudoOk &= $stmt->affected_rows !== 0;

        $ID_orcamento = $conn->insert_id;

        $folder = 'ficheiros_stl/orcamentos/';

        if ($_FILES['ficheiro']['name'][0]) {

            foreach ($_FILES['ficheiro']['name'] as $key => $ficheiro) {
                $stl_file = $_FILES['ficheiro']['name'][$key];
                $extension = strtolower(pathinfo($stl_file, PATHINFO_EXTENSION));

                if (!$tudoOk) {
                    $_SESSION['error_msg'] = 'Não foi possível adicionar o ficheiro STL';
                    break;
                }

                if ($extension != 'stl') {
                    $_SESSION['error_msg'] = 'Ficheiro não permitido!!';
                }

                $ficheiro = uniqid() . '.' . $extension;

                move_uploaded_file($_FILES['ficheiro']['tmp_name'][$key], $folder . $ficheiro);

                $stmt = $conn->prepare('INSERT INTO orçamentos (nome, descricao, ficheiro, ID_categoria, ID_utilizador) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('sssii', $nome, $descricao, $ficheiro, $categoria, $utilizador);
                $stmt->execute();

                $tudoOk &= $stmt_f->affected_rows !== 0;
            }
        }

        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'A sugestão para orçamento não foi adicionada';

            $conn->rollback();
            header('Location: insert_prod.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'A sugestão para orçamento foi adicionada com sucesso';
            $conn->commit();
            header('Location: insert_prod.php?msg=success');
        }

        break;

        /********************************************************************************************************************************************/
        /*                                                                    MANAGE_USERS                                                          */
        /********************************************************************************************************************************************/

    case 'del_user':
        $ID = $_GET['ID'];

        $stmt = $conn->prepare('SELECT foto FROM utilizadores WHERE ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $results = $stmt->get_result();
        $row = $results->fetch_assoc();

        $conn->begin_transaction();

        if (@$row['foto'] && file_exists('imgs/users/profile_pics/' . $row['foto']))
            unlink('imgs/users/profile_pics/' . $row['foto']);


        $stmt = $conn->prepare('DELETE FROM utilizadores WHERE ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();

        if ($stmt === 0) {
            $_SESSION['error_msg'] = 'Não foi possível eliminar o utilizador!';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'Utilizador eliminado com sucesso!';
            $conn->commit();
            header('Location: adm_configs.php?msg=success');
        }
        break;

    case 'get_user':

        if (@$_GET['act'] === 'get_user' && $_GET['ID']) {
            $ID = $_GET['ID'];
            $stmt = $conn->prepare('SELECT * FROM utilizadores WHERE ID = ?');
            $stmt->bind_param('i', $ID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Retorna os dados em JSON
            echo json_encode($userData = $result->fetch_assoc());
            exit;
        }
        break;

    case 'edit_user':

        $ID = htmlentities($_POST['ID']);
        $nome = htmlentities($_POST['nome']);
        $morada = htmlentities($_POST['morada']);
        $cod_postal = htmlentities($_POST['cod_postal']);
        $telefone = htmlentities($_POST['telefone']);
        $nif = htmlentities($_POST['nif']);
        $nickname = htmlentities($_POST['nickname']);
        $email = htmlentities($_POST['email']);

        $conn->begin_transaction();

        // Editar com foto: quando envia uma imagem
        if ($_FILES['foto']['size'] !== 0) {
            //obter a imagem para depois a apagar
            $stmt = $conn->prepare('SELECT foto FROM utilizadores WHERE ID = ?');
            $stmt->bind_param('i', $ID);
            $stmt->execute();
            $results = $stmt->get_result();
            $row = $results->fetch_assoc();


            if ($row['foto'] && file_exists('imgs/users/profile_pics/' . $row['foto'])) {
                unlink('imgs/users/profile_pics/' . $row['foto']);

                //Verificar se a imagem continua a existir
                if (file_exists('imgs/users/profile_pics/' . $row['foto'])) {

                    $_SESSION['error_msg'] = 'Não foi possível eliminar o ficheiro, tente novamente o processo de edição...';
                    header('Location: adm_configs.php?msg=error');
                    exit;
                }
            }


            //Receber a nova imagem
            $folder = 'imgs/users/profile_pics/';

            $u_file_name = $_FILES['foto']['name'];
            $extension = strtolower(pathinfo($u_file_name, PATHINFO_EXTENSION));

            //jpg jpeg bmp png tiff gif
            if (
                $extension != 'jpg' &&
                $extension != 'jpeg' &&
                $extension != 'bmp' &&
                $extension != 'png' &&
                $extension != 'tiff' &&
                $extension != 'gif'
            )
                die("Ficheiro não permitido!");

            $file = uniqid() . '.' . $extension;

            move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $file);

            $stmt = $conn->prepare('UPDATE utilizadores SET nome = ?, morada = ?, cod_postal = ?, telefone = ?,
                                           nif = ?, nickname = ?, email = ?, foto = ? WHERE ID = ?');
            $stmt->bind_param('ssssisssi', $nome, $morada, $cod_postal, $telefone, $nif, $nickname, $email, $file, $ID);
            $stmt->execute();


            if ($stmt->affected_rows === 0) {
                $_SESSION['error_msg'] = 'Não foi possível editar o utilizador adicionando uma foto - tente novamente o processo de edição...';
                $conn->rollback();
                header('Location: adm_configs.php?msg=error');
                exit;
            } else {
                $_SESSION['info_msg'] = 'Utilizador alterado com sucesso!';
                $conn->commit();
                header('Location: adm_configs.php?msg=success');
            }
        } else {
            // Editar sem foto
            $stmt = $conn->prepare('UPDATE utilizadores SET nome = ?, morada = ?, cod_postal = ?, telefone = ?,
                                           nif = ?, nickname = ?, email = ? WHERE ID = ?');
            $stmt->bind_param('ssssissi', $nome, $morada, $cod_postal, $telefone, $nif, $nickname, $email, $ID);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                $_SESSION['error_msg'] = 'Não foi possível editar o utilizador (Talvez não tenha feito edição?)';
                $conn->rollback();
                header('Location: adm_configs.php?msg=error');
                exit;
            } else {
                $_SESSION['info_msg'] = 'Utilizador alterado com sucesso!';
                $conn->commit();
                header('Location: adm_configs.php?msg=success');
            }
        }
        break;

        /********************************************************************************************************************************************/
        /*                                                                    MANAGE_PRODS                                                          */
        /********************************************************************************************************************************************/


    case 'del_prod':

        $ID = $_GET['ID'];
        $tudoOk = true;

        $stmt = $conn->prepare('SELECT f.foto, c.c_descricao FROM fotos AS f
                                JOIN produtos AS p ON p.ID = f.ID_produto
                                JOIN categorias AS c ON c.ID = p.ID_categoria
                                WHERE p.ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $results = $stmt->get_result();

        while ($row = $results->fetch_assoc()) {

            if (@$row['foto'] && file_exists('imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto']))
                unlink('imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto']);
        }

        $conn->begin_transaction();

        $stmt = $conn->prepare('DELETE f.foto FROM fotos AS f
                                JOIN produtos AS p ON p.ID = f.ID_produto
                                WHERE p.ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $tudoOk &= $stmt->affected_rows !== 0;

        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Não foi possível eliminar as fotos do produto!<br>O processo será revertido';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $stmt = $conn->prepare('DELETE pf FROM produtos_filamentos_cores AS pf
                                    JOIN produtos AS p ON p.ID = pf.ID_produto
                                    WHERE p.ID = ?');
            $stmt->bind_param('i', $ID);
            $stmt->execute();
            $tudoOk &= $stmt->affected_rows !== 0;
        }
        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Não foi possível eliminar o produto!';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $stmt = $conn->prepare('DELETE FROM produtos
                                    WHERE ID = ?');
            $stmt->bind_param('i', $ID);
            $stmt->execute();
            $tudoOk &= $stmt->affected_rows !== 0;
        }
        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Não foi possível eliminar o produto!';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'Produto eliminado com sucesso!';
            $conn->commit();
            header('Location: adm_configs.php?msg=success');
        }

        break;

    case 'del_prod_foto':

        $ID = $_GET['ID'];
        $imageId = $_GET['ID_foto']; // Se você também passar o ID da imagem

        $tudoOk = true;
        $conn->begin_transaction();
        
        $stmt = $conn->prepare('SELECT f.foto, ct.c_descricao FROM fotos AS f 
                                JOIN produtos AS p ON p.ID = f.ID_produto
                                JOIN categorias AS ct ON ct.ID = p.ID_categoria
                                WHERE p.ID = ? AND f.ID = ?');
        $stmt->bind_param('ii', $ID, $imageId);
        $stmt->execute();
        $results = $stmt->get_result();
        $row = $results->fetch_assoc();

        if ($row['foto'] && file_exists('imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto'])) {
            unlink('imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto']);

            //Verificar se a imagem continua a existir
            if (file_exists('imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto'])) {

                $_SESSION['error_msg'] = 'Não foi possível eliminar as fotos existentes, tenta novamente o processo de edição...';
                header('Location: adm_configs.php?msg=error');
                exit;
            }
        }

        $stmt = $conn->prepare('DELETE FROM fotos WHERE ID_produto = ? AND ID = ?');
        $stmt->bind_param('ii', $ID, $imageId);
        $stmt->execute();
        // $tudoOk &= $stmt->affected_rows !== 0;
        if ($stmt->affected_rows === 0) {
            $_SESSION['error_msg'] = 'Não foi possível eliminar as fotos do produto!<br>O processo será revertido';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'Foto eliminada com sucesso!';
            $conn->commit();
            header('Location: adm_configs.php?msg=success');
        }

        break;

    case 'get_prod':

        $ID = $_GET['ID'];
        $stmt = $conn->prepare('SELECT p.ID, p.nome, p.descricao, ct.ID AS ID_categoria, ct.c_descricao, f.foto, f.ID AS ID_foto, fl.ID AS ID_filamento, c.ID AS ID_cor, p.preco
                                FROM produtos AS p 
                                JOIN categorias AS ct ON ct.ID = p.ID_categoria
                                LEFT JOIN fotos AS f ON f.ID_produto = p.ID
                                JOIN produtos_filamentos_cores AS pf ON pf.ID_produto = p.ID
                                JOIN filamentos AS fl ON fl.ID = pf.ID_filamento
                                JOIN cores AS c ON c.ID = pf.ID_cor
                                WHERE p.ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $result = $stmt->get_result();

        $fotos = [];
        while ($row = $result->fetch_assoc()) {
            $prodData = [
                'ID' => $row['ID'],
                'nome' => $row['nome'],
                'descricao' => $row['descricao'],
                'ID_categoria' => $row['ID_categoria'],
                'c_descricao' => $row['c_descricao'],
                'ID_filamento' => $row['ID_filamento'],
                'ID_cor' => $row['ID_cor'],
                'preco' => $row['preco'],
            ];
            $fotos[] =[
                'ID_foto' => $row['ID_foto'], 
                'foto' => $row['foto']];
        }

        $prodData['fotos'] = $fotos;

        // Retorna os dados em JSON
        echo json_encode($prodData);
        exit;
        break;

    case 'edit_prod':

        $ID = htmlentities($_POST['ID']);
        $nome = htmlentities($_POST['nome']);
        $descricao = htmlentities($_POST['descricao']);
        $preco = htmlentities($_POST['preco']);
        $categoria = $_POST['categoria'];
        $filamentos = $_POST['filamento'];
        $cores = $_POST['cor'];
        $utilizador = htmlentities($_SESSION['ID']);

        // die(print_r($_SESSION));

        $tudoOk = true;
        $conn->begin_transaction();


        $stmt = $conn->prepare('SELECT ct.c_descricao FROM categorias AS ct 
                                JOIN produtos AS p ON p.ID_categoria = ct.ID
                                WHERE p.ID = ?');
        $stmt->bind_param('i', $ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        //Receber a nova imagem
        $folder = 'imgs/produtos/' . $row['c_descricao'] . '/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }


        if ($_FILES['foto']['name'][0]) {

            $stmt = $conn->prepare('SELECT f.foto FROM fotos AS f 
                                    JOIN produtos AS p ON p.ID = f.ID_produto
                                    WHERE p.ID = ?');
            $stmt->bind_param('i', $ID);
            $stmt->execute();
            $results = $stmt->get_result();



            $fotosExistentes = [];
            while ($row = $results->fetch_assoc()) {
                $fotosExistentes[] = $row['foto'];
            }


            $fotosFormulario = [];
            foreach ($_FILES['foto']['name'] as $key => $foto) {

                // $foto_name = $_FILES['foto']['name'][$key];
                $extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
                $nomeBase = pathinfo($foto, PATHINFO_FILENAME);
                $foto = $nomeBase . '' . $key . '.' . $extension;

                if (
                    $extension != 'jpg' &&
                    $extension != 'jpeg' &&
                    $extension != 'bmp' &&
                    $extension != 'png' &&
                    $extension != 'tiff' &&
                    $extension != 'gif'
                ) {
                    $_SESSION['error_msg'] = 'Ficheiro não permitido!!';
                    $conn->rollback();
                    exit;
                }

                $fotosFormulario[] = $foto;

                move_uploaded_file($_FILES['foto']['tmp_name'][$key], $folder . $foto);
            }

            $fotosNovas = array_diff($fotosFormulario, $fotosExistentes); // Ver a diferença entre os arrays de modo a obter as fotos que não existem na base de dados
            $fotosParaUpdate = array_intersect($fotosFormulario, $fotosExistentes); // Ver a existencia de fotos na base de dados em relação ao formulario para determinar se devem ser atualizadas 

            foreach ($fotosNovas as $foto) {
                $stmt_img = $conn->prepare('INSERT INTO fotos (foto, ID_produto) 
                                            VALUES (?, ?)');
                $stmt_img->bind_param('si', $foto, $ID);
                $stmt_img->execute();

                $tudoOk &= !$stmt_img->error;

                if (!$tudoOk) {
                    $_SESSION['error_msg'] = 'Não foi possível Inserir fotos novas';
                    $conn->rollback();
                    break;
                }
            }

            foreach ($fotosParaUpdate as $foto) {
                $stmt_img = $conn->prepare('UPDATE fotos SET foto=? 
                                            WHERE ID_produto = ?
                                            AND foto = ?');
                $stmt_img->bind_param('sis', $foto, $ID, $foto);
                $stmt_img->execute();

                $tudoOk &= !$stmt_img->error;
                if (!$tudoOk) {
                    $_SESSION['error_msg'] = 'Não foi possível atualizar a(s) foto(s) introduzidas...';
                    $conn->rollback();
                    exit;
                }
            }
        }




        $stmt = $conn->prepare('UPDATE produtos SET nome = ?, descricao = ?, 
                                preco = ?, ID_categoria = ?, ID_utilizador = ? 
                                WHERE ID = ?');
        $stmt->bind_param('ssdiii', $nome, $descricao, $preco, $categoria, $utilizador, $ID);
        $stmt->execute();

        $tudoOk &= !$stmt->error;

        $filamentos = array_filter($filamentos);
        $cores = array_filter($cores);


        $stmt_fil_cor = $conn->prepare('UPDATE produtos_filamentos_cores SET ID_filamento = ?, ID_cor = ? 
                                            WHERE ID_produto = ?
                                            AND NOT EXISTS (SELECT * FROM produtos_filamentos_cores 
                                                            WHERE ID_produto = ? AND ID_filamento = ? AND ID_cor = ?)');

        foreach ($filamentos as $key => $ID_filamento) {
            if (!$tudoOk) {

                echo 'dados POST: ';
                print_r($_POST);
                echo 'dados FILES: ';
                print_r($_FILES);
                die("Erro ao atualizar o produto: " . $stmt_fil_cor->error);
                $_SESSION['error_msg'] = 'Não foi possível associar filamentos e/ou cores';
                $conn->rollback();
                break;
            }

            $ID_cor = $cores[$key];

            $stmt_fil_cor->bind_param('iiiiii', $ID_filamento, $ID_cor, $ID, $ID, $ID_filamento, $ID_cor);
            $stmt_fil_cor->execute();

            // $tudoOk &= $stmt_fil_cor->affected_rows !== 0;
            $tudoOk &= !$stmt->error;
        }


        $tudoOk_STL = true;

        $folder = 'ficheiros_stl/';

        if ($_FILES['ficheiro']['name'][0]) {

            foreach ($_FILES['ficheiro']['name'] as $key => $ficheiro) {
                $stl_file = $_FILES['ficheiro']['name'][$key];
                $extension = strtolower(pathinfo($stl_file, PATHINFO_EXTENSION));

                if (!$tudoOk_STL) {
                    $_SESSION['error_msg'] = 'Não foi possível adicionar o ficheiro STL';
                    $conn->rollback();
                    break;
                }

                if ($extension != 'stl')
                    $_SESSION['error_msg'] = 'Ficheiro não permitido!!';

                $ficheiro = uniqid() . '.' . $extension;

                move_uploaded_file($_FILES['ficheiro']['tmp_name'][$key], $folder . $ficheiro);

                $stmt_f = $conn->prepare('UPDATE ficheiros_stl SET ficheiro = ? 
                                          WHERE ID_produto = ?');
                $stmt_f->bind_param('si', $ficheiro, $ID);
                $stmt_f->execute();

                // $tudoOk_STL &= $stmt_f->affected_rows !== 0;
                $tudoOk &= !$stmt->error;
            }
        } else {

            $tudoOk_STL = false;
            // $_SESSION['info_msg'] = 'Não foi introduzido nenhum ficheiro STL<br><br>
            //                          Mas podes fazê-lo mais tarde ;)';
        }

        if (!$tudoOk) {
            $_SESSION['error_msg'] = 'Não foi possível editar o produto';
            $conn->rollback();
            header('Location: adm_configs.php?msg=error');
            exit;
        } else {
            $_SESSION['info_msg'] = 'Produto Editado com sucesso!';
            $conn->commit();
            header('Location: adm_configs.php?msg=success');
        }

        break;

        /********************************************************************************************************************************************/
        /*                                                                    SEARCH                                                                */
        /********************************************************************************************************************************************/

    case 'search':
        $search = $_POST['search'];

        $stmt = $conn->prepare('SELECT p.nome FROM produtos AS p 
                            JOIN categorias AS c ON p.ID_categoria = c.ID
                            WHERE p.nome OR c.c_descricao LIKE ?');
        $stmt->bind_param('s', $search);
        $stmt->execute();
        break;
}
