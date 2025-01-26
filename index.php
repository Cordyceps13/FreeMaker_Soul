<?php
$title = "Home";
include 'header.php';
?>

<div class="banner">
  <div class="wrapper">
    <h1>Freemaker Soul</h1>
    <hr class="sep">
  </div>
</div>

<div class="product-sample wrapper">
  <?php
  $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.preco, MIN(f.foto) AS foto
          FROM produtos AS p
          JOIN fotos AS f ON f.ID_produto = p.ID
          JOIN categorias AS c ON c.ID = p.ID_categoria
          GROUP BY p.ID,  p.nome, p.preco';

  $result = $conn->query($sql);

  for ($i = 0; $i < 4; $i++) {

    if ($row = $result->fetch_assoc()) {
  ?>
      <div class="product">
        <a href="product_details.php?produto=<?= $row['ID'] ?>">
          <img src="imgs/produtos/<?= $row['c_descricao'] ?>/<?= $row['foto'] ?>" alt="<?= $row['nome'] ?>" title="Ver detalhes">
        </a>
        <div class="nome_prod" title="Nome do Produto"><?= $row['nome'] ?></div>
        <div class="preco" title="Preço"><?= $row['preco'] ?>€</div>
      </div>
  <?php
    }
  }
  ?>
</div>
<div class="mais_container wrapper">
  <a href="products.php" title="Ver mais produtos">
    <button class="mais">Ver mais produtos</button>
  </a>
</div>

<?php
include 'footer.php';
?>