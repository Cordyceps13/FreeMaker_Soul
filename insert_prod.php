<?php
ob_start(); /*Criar buffer temporário que armazena o conteúdo da página que só será mostrado após ser limpo*/
$title = "Inserir Produtos";
include 'header.php';
if (!$_SESSION) {
    header('Location: login.php');
    ob_flush();/*Encaminhar o que está em cache*/
    exit();
}
ob_end_flush(); /*Apagar a cache anterior e deixar o conteúdo ser mostrado em tempo real*/
?>

<?php
if (@$_SESSION['adm']) {
?>

    <div class="insert_product_container">
        <form class="insert_product" id="insert_product" action="actions.php?act=insert_product" method="POST" enctype="multipart/form-data">
            <div class="insert_title wrapper">
                Inserção de Novo Produto<br>
                <hr>
            </div>
            <div class="input-box" id="input-box">
                <input type="text" name="nome_prod" placeholder="Nome do produto">
            </div>
            <div class="input-box" id="input-box">
                <textarea class="descricao" name="descricao" rows="4" placeholder="Descrição do produto"></textarea>
            </div>
            <div class="input-box" id="product-images">
                <div id="product-images-list">
                </div>
                <input type="file" id="foto" name="foto[]" accept="image/*" style="display:none;" multiple>
                <button class="img_btn">Inserir Imagens</button>
            </div>
            <div class="preco input-box" id="input-box">
                <label for="preco">Preço (€):</label>
                <input type="number" name="preco" step="0.1" min="0">
            </div>
            <div class="input-box" id="input-box">
                <select name="categoria">
                    <option value="">Escolha uma categoria</option>
                    <?php
                    $result = $conn->query('SELECT ID, c_descricao FROM categorias');
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option value="<?= $row['ID'] ?>"><?= $row['c_descricao'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="input-box fil">
                <select class="filamento" id="filamento" name="filamento[]">
                    <option value="">Escolha um tipo de filamento</option>
                    <?php
                    $result = $conn->query('SELECT ID, tipo FROM filamentos');
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option name="filamento" value="<?= $row['ID'] ?>"> <?= $row['tipo'] ?> </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="add_btn_container" id="add_fil" style="display: none;">
                <div class="add_btn">
                    <img src="imgs/icons/add.png" alt="Botão de adicionar mais filamentos" title="Adicionar mais filamentos">
                </div>
            </div>
            <div class="input-box cor" id="input-box">
                <select class="cor" id="cor" name="cor[]">
                    <option value="">Escolha uma cor</option>
                    <?php
                    $result = $conn->query('SELECT ID, cor FROM cores');
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option name="cor" value="<?= $row['ID'] ?>"> <?= $row['cor'] ?> </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="add_btn_container" id="add_cor" style="display: none;">
                <div class="add_btn">
                    <img src="imgs/icons/add.png" alt="Botão de adicionar mais cores" title="Adicionar mais cores">
                </div>
            </div>
            <div class="input-box" id="input-box">
                <label for="ficheiro">Ficheiro STL:</label>
                <div class="stl_files" id="stl_files"></div>
                <input class="stl" type="file" id="ficheiro" name="ficheiro[]" accept=".stl" style="display:none;" multiple>
                <button class="stl_btn">Escolher Ficheiros</button>
            </div>
            <div class="add_btn_container" id="add_btn_container" style="display: none;">
                <div class="add_btn">
                    <img src="imgs/icons/add.png" alt="Botão de adicionar ficheiro" title="Adicionar mais ficheiros">
                </div>
            </div>
            <div>
                <button id="btn" class="btn" type="submit">Inserir Produto</button>
            </div>
        </form>
    </div>

<?php
} else {
?>
    <div class="insert_product_container">
        <form class="insert_product" id="insert_product" action="actions.php?act=sugest_product" method="POST" enctype="multipart/form-data">
            <div class="insert_title wrapper">
                Pedido de orçamento
                <hr>
            </div>
            <div class="input-box" id="input-box">
                <input type="text" name="nome_prod" placeholder="Nome do produto">
            </div>
            <div class="input-box">
                <textarea class="descricao" name="descricao" rows="4" placeholder="Descrição do produto"></textarea>
            </div>
            <div class="input-box" id="input-box">
                <select name="categoria">
                    <option value="">Escolha uma categoria</option>
                    <?php
                    $result = $conn->query('SELECT ID, c_descricao FROM categorias');
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <option value="<?= $row['ID'] ?>"><?= $row['c_descricao'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="input-box" id="input-box">
                <label for="ficheiro">Ficheiro STL:</label>
                <input class="stl" type="file" id="ficheiro" name="ficheiro[]" accept=".stl" style="display:none;">
                <div class="stl_files" id="stl_files"></div>
                <button class="stl_btn">Escolher Ficheiros</button>
            </div>
            <div class="add_btn_container" id="add_btn_container" style="display: none;">
                <div class="add_btn">
                    <img src="imgs/icons/add.png" alt="Botão de adicionar ficheiro" title="Adicionar mais ficheiros">
                </div>
            </div>
            <div>
                <button id="btn" class="btn" type="submit">Inserir Produto</button>
            </div>
        </form>
    </div>
<?php
} ?>
<script>
    $(document).ready(function() {

        $('.descricao').on('input', function() {
            $(this).css('height', 'auto');
            $(this).css('height', this.scrollHeight + 'px');
        });

        $('.img_btn').on('click', function(e) {
            e.preventDefault();
            $('#foto').click();
        });

        $('#foto').on('change', function(e) {
            const foto = e.target.files[0];

            for (let i = 0; i < this.files.length; i++) {
                let reader = new FileReader();
                let img_preview = $(`<img class="preview-${i}" />`);

                reader.onload = function(e) {
                    img_preview.attr("src", e.target.result);
                }
                reader.readAsDataURL(this.files[i]);
                $('#product-images-list').append(img_preview);
            }

        });


        function verificarSelecaoFilamento() {
            // Verifica se qualquer <select> de filamento possui uma seleção válida
            const algumFilamentoSelecionado = $('.filamento').filter(function() {
                return $(this).val();
            }).length > 0;

            // Exibe o botão se algum filamento estiver selecionado; caso contrário, oculta
            document.getElementById('add_fil').style.display = algumFilamentoSelecionado ? 'block' : 'none';
        }

        // Aplica o evento de mudança a todos os selects de filamento atuais e futuros
        $(document).on('change', '.filamento', verificarSelecaoFilamento);

        $('#add_fil').on('click', function(e) {
            e.preventDefault();
            verificarSelecaoFilamento();

            // Cria um novo select de filamento
            const newSelectContainer = $('<div class="input-box fil"></div>');
            const newSelect = $('<select class="filamento"></select>');

            // Copia as opções do primeiro select 
            $('#filamento option').each(function() {
                newSelect.append($(this).clone());
            });

            // Adiciona o novo select ao DOM
            newSelectContainer.append(newSelect);
            $('.input-box.fil').last().after(newSelectContainer);

            verificarSelecaoFilamento();

            // Oculta o botão "Adicionar Filamento" logo após criar um novo select
            document.getElementById('add_fil').style.display = 'none';
        });


        function verificarSelecaoCor() {
            // Verifica se qualquer <select> de cor possui uma seleção válida
            const algumCor = $('.cor').filter(function() {
                return $(this).val();
            }).length > 0;

            // Exibe o botão se algum filamento estiver selecionado; caso contrário, oculta
            document.getElementById('add_cor').style.display = algumCor ? 'block' : 'none';
        }

        // Aplica o evento de mudança a todos os selects de filamento atuais e futuros
        $(document).on('change', '.cor', verificarSelecaoCor);

        $('#add_cor').on('click', function(e) {
            e.preventDefault();
            verificarSelecaoCor();

            // Cria um novo select de filamento
            const newSelectContainer = $('<div class="input-box cor"></div>');
            const newSelect = $('<select class="cor"></select>');

            // Copia as opções do primeiro select 
            $('#cor option').each(function() {
                newSelect.append($(this).clone());
            });

            // Adiciona o novo select ao DOM
            newSelectContainer.append(newSelect);
            $('.input-box.cor').last().after(newSelectContainer);

            verificarSelecaoCor();

            // Oculta o botão "Adicionar Filamento" logo após criar um novo select
            document.getElementById('add_cor').style.display = 'none';
        });


        $('.stl_btn').on('click', function(e) {
            e.preventDefault();
            $('#ficheiro').click();
        });


        $('#ficheiro').on('change', function() {
            const fileCount = this.files.length;
            const fileCountMsg = $('<p class="file-count"></p>').text(`${fileCount} ficheiros adicionados`);

            // Adiciona a mensagem de contagem ao contêiner
            $('#stl_files').append(fileCountMsg);
        });


        $('.insert_product').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (document.activeElement.tagName !== 'BUTTON') {
                    $(this).submit();
                }
            }
        });


        function scrollToElement(element, breathe = 0) {
            if (element.length) {
                element[0].focus();
                window.requestAnimationFrame(function() {
                    element[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    if (breathe) {
                        element.addClass('breathing');
                        setTimeout(function() {
                            element.removeClass('breathing');
                        }, 2200);
                    }
                });
            }
        }

        if (<?= $_SESSION['adm'] ?>) {
            $('.insert_product').on('submit', function(e) {
                let nome = $('input[name="nome_prod"]');
                let foto = $('#foto');
                let preco = $('input[name="preco"]');
                let categoria = $('select[name="categoria"]');

                if ($.trim(nome.val()) == "") {
                    alert("Erro: É necessário introduzir um nome para o produto!");
                    e.preventDefault();
                    scrollToElement(nome);
                    return false;
                }

                if (foto[0].files.length === 0) {
                    alert("Erro: Tens que introduzir pelo menos uma foto!");
                    e.preventDefault();
                    scrollToElement($('.img_btn'), 1);
                    return false;
                }

                if ($.trim(preco.val()) == "") {
                    alert("Erro: Convém introduzir um preço....");
                    scrollToElement(preco);
                    e.preventDefault();
                    return false;
                }

                if ($.trim(categoria.val()) == "") {
                    alert("Erro: Tens que escolher uma categoria!");
                    scrollToElement(categoria);
                    e.preventDefault();
                    return false;
                }
            });

        } else {
            $('.insert_product').on('submit', function(e) {
                let nome = $('input[name="nome_prod"]');
                let categoria = $('select[name="categoria"]');
                let ficheiro = $('#ficheiro');

                if ($.trim(nome.val()) == "") {
                    alert("Erro: É necessário introduzir um nome para o produto!");
                    scrollToElement(nome);
                    e.preventDefault();
                    return false;
                }

                if ($.trim(categoria.val()) == "") {
                    alert("Erro: É necessário escolher uma categoria!");
                    scrollToElement(categoria);
                    e.preventDefault();
                    return false;
                }

                if (ficheiro[0].files.length === 0) {
                    alert("Erro: Tens que introduzir um ficheiro STL!");
                    e.preventDefault();
                    scrollToElement($('.stl_btn'), 1);
                    return false;
                }
            });
        };

    });
</script>

<?php
include 'footer.php';
?>