<?php
$title = 'Detalhes Produto';
include 'header.php';
@$produto = $_GET['produto'];
?>
<div class="product_detail_container wrapper">
    <div class="product_container">
        <?php
        $sql = 'SELECT f.foto, p.nome, c.c_descricao
                    FROM fotos AS f
                    JOIN produtos AS p ON p.ID = f.ID_produto
                    JOIN categorias AS c ON c.ID = p.ID_categoria
                    WHERE p.ID = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $produto);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="slideshow_container">
            <img class="prev_icon" onclick="slide(-1)" src="imgs/icons/arrow.png" alt="">
            <img class="next_icon" onclick="slide(1)" src="imgs/icons/arrow.png" alt="">
            <div class="slideshow">
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <a href="imgs/produtos/<?= $row['c_descricao'] ?>/<?= $row['foto'] ?>" target="_blank">
                        <img class="img" src="imgs/produtos/<?= $row['c_descricao'] ?>/<?= $row['foto'] ?>" alt="<?= $row['nome'] ?>">
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="img_selector">

            <?php
            $result->data_seek(0); //Fazer reset ao array
            $img_index = 0;
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="product_imgs">
                    <a href="#">
                        <img class="img" onclick="img_click(<?= $img_index ?>)" src="imgs/produtos/<?= $row['c_descricao'] ?>/<?= $row['foto'] ?>" alt="<?= $row['nome'] ?>" title="Ver Imagem">
                    </a>
                </div>
            <?php
                $img_index++;
            }
            ?>

        </div>
    </div>
    <?php
    $sql = 'SELECT p.nome, p.descricao, c.c_descricao, p.preco
                FROM produtos AS p
                JOIN categorias AS c ON c.ID = p.ID_categoria
                WHERE p.ID = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $produto);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    ?>
    <div class="product_description">
        <div class="container_description">
            <h2 class="nome"><?= $row['nome'] ?></h2>
            <div class="descricao"><strong>Descrição:</strong> <?= $row['descricao'] ?></div><br>
            <div class="categoria"><strong>Categoria:</strong> <?= $row['c_descricao'] ?></div><br>
            <div class="filamento"><strong>Feito em:</strong>
                <?php
                $sql = 'SELECT f.ID, f.tipo
                                FROM filamentos AS f
                                JOIN produtos_filamentos_cores AS pf ON pf.ID_filamento = f.ID
                                JOIN produtos AS p ON p.ID = pf.ID_produto
                                WHERE p.ID = ?';

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $produto);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row_fil = $result->fetch_assoc())
                    $filamentos[] = $row_fil['tipo'];
                if (@$filamentos)
                    echo implode(',', $filamentos);
                ?>
                <br><br>
            </div>
            <div class="cor"><strong>Cor(es):</strong>
                <?php
                $sql = 'SELECT c.ID, c.cor
                                FROM cores AS c
                                JOIN produtos_filamentos_cores AS pc ON pc.ID_cor = c.ID
                                JOIN produtos AS p ON p.ID = pc.ID_produto
                                WHERE p.ID = ?';

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $produto);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row_cor = $result->fetch_assoc())
                    $cores[] = $row_cor['cor'];
                if (@$cores)
                    echo implode(',', $cores);
                ?>
                <br><br>
                <div class="preco"><strong>Preço:</strong> <u><?= $row['preco'] ?>€</u></div><br><br>
            </div>
            <div class="seletores">
                <div class="filamento">
                    <select name="escolher_filamento" id="escolher_filamento">
                        <option value="">Escolha um tipo de filamento</option>
                        <?php
                        $result = $conn->query('SELECT ID, tipo FROM filamentos');
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option name="filamento" value="<?= $row['ID'] ?>"> <?= $row['tipo'] ?> </option>';
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="cor">
                    <select name="escolher_cor" id="escolher_cor">
                        <option value="">Escolha uma cor</option>
                        <?php
                        $result = $conn->query('SELECT ID, cor FROM cores');
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option name="cor" value="<?= $row['ID'] ?>"> <?= $row['cor'] ?> </option>';
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div><br>
            <hr>
            <div class="add_to_cart">
                <div class="quantidade">
                    <label for="quantity"><strong>Quantidade:</strong></label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                </div>
                <div class="add_btn">
                    <button type="submit">Adicionar ao carrinho</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>

<script>
    $(document).ready(function() {
        //TESTE CAROUSEL
        let slide_index = 0;
        const slides = $('.slideshow_container .img');

        //Função para mostrar apenas a 1ª img do array
        function mostrarSlide(index) {
            slides.hide(); // Esconde todas as imagens
            slides.eq(index).show(); // Mostra apenas a imagem atual
        }

        // Mostrar a 1ª imagem do array
        mostrarSlide(slide_index);

        // Função para mudar de imagem com os botões prev e next
        slide = function(direcao) {
            slide_index += direcao;

            // Voltar à última img
            if (slide_index < 0) {
                slide_index = slides.length - 1;
            }
            // Voltar à primeira img
            else if (slide_index >= slides.length) {
                slide_index = 0;
            }

            // Mostrar a nova imagem
            mostrarSlide(slide_index);
        };

        //Função para mostrar a imagem que for carregada no seletor de baixo
        img_click = function(index) {
            slide_index = index; // Recebe o indice que foi incrementado por cada imagem no loop while
            mostrarSlide(slide_index);
        };

    });
</script>