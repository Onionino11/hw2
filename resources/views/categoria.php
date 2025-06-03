<?php
// categoria.php
// Riceve la query della categoria tramite GET e mostra i prodotti corrispondenti
$query = isset($_GET['query']) ? $_GET['query'] : '';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Categoria: <?php echo htmlspecialchars($query); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Categoria: <?php echo htmlspecialchars($query); ?></h1>
    <div id="panel-body"></div>
    <script>
    // Esegue la fetch dei prodotti della categoria
    const query = '<?php echo addslashes($query); ?>';
    fetch('../php/prodotti.php?query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            const Results = data.results;
            const panelBody = document.getElementById('panel-body');
            for (const item of Results) {
                const div = document.createElement('div');
                div.className = 'panel-item';
                div.textContent = item.nome + ' - ' + (item.prezzo || '') + '€';
                panelBody.appendChild(div);
            }
        })
        .catch(error => {
            document.getElementById('panel-body').textContent = 'Errore nel caricamento dei prodotti.';
        });
    </script>
</body>
</html>
