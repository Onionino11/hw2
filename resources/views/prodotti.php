<html>
<head>
    <?php include 'header.php'; ?>
    <script src="../assets/js/index.js" defer></script>
</head>
<body>
    <div id="modal-view" class="hidden"></div>
    <?php include 'navbar.php'; ?>
    <?php include 'header_section.php'; ?>
    <?php include 'navigazione.php'; ?>
    <article>
        <section id="panel">
          <div id="panel-heading"> <img class="panel-icon" class="icon" src="../assets/img/tag.png"> <?php echo $_GET["categoria"] ?></div>
            <div id="panel-body">  </div>
        </section>
        <?php include 'cart.php'; ?>
    </article>
    <?php include 'footer.php'; ?>
    
</body>
</html>
