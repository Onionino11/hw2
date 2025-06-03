<html>
<head>
    <?php include 'header.php'; ?>
</head>

<body>
    <div id="modal-view" class="hidden"></div>
    <?php include 'navbar.php'; ?>
    <?php include 'header_section.php'; ?>
    <?php include 'navigazione.php'; ?>

    <article>
        <section id="panel">
            <div id="panel-heading"> <img class="panel-icon" class="icon" src="../assets/img/key.svg"> Registrazione</div>
            <div id="panel-body">
                <form action="salva.php" method="post" class="form">

                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input type="email" name="email" value="" class="form-control" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <div class="controls">
                            <input type="password" name="password" value="" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="control-label">Conferma password</label>
                        <div class="controls">
                            <input type="password" name="confirm_password" value="" class="form-control"
                                placeholder="Conferma password">
                        </div>
                    </div>


                    <hr>

                    <div class="form-group">
                        <label for="first_name" class="control-label">Nome</label>
                        <div class="controls">
                            <input type="text" name="first_name" value="" class="form-control" placeholder="Nome">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="control-label">Cognome</label>
                        <div class="controls">
                            <input type="text" name="last_name" value="" class="form-control" placeholder="Cognome">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="birthday" class="control-label">Data di nascita</label>
                        <div class="controls">
                            <div class="control-input-date">
                                <input type="date" name="birthday" value="" class="form-control"
                                    placeholder="Data di nascita">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="city" class="control-label">Città</label>
                        <div class="controls">
                            <div class="row">
                                <div class="campo1">
                                    <input type="text" name="city" value="" class="form-control pac-target-input"
                                        placeholder="Città">
                                </div>
                                <div class="campo2">
                                    <input type="text" name="province" value="" class="form-control"
                                        placeholder="Provincia">
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="form-group">
                        <label for="phone" class="control-label">Telefono</label>
                        <div class="controls">
                            <input type="text" name="phone" value="" class="form-control" placeholder="Telefono">
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="control-label"></label>
                        <div class="signup-accept-marketing" >
                        <div >
                            <p>
                                Acconsento al trattamento dei miei dati personali per: </p>

                            <input type="hidden" name="accept_marketing" value="0">
                            <div class="checkbox">
                                <label  class="control-label">
                                    <input type="checkbox" name="accept_marketing" value="1"> Ricevere sconti
                                    esclusivi, novità ed offerte </label>
                            </div>
                            <p>
                                Registrandoti accetti la nostra <a href="#">politica sulla privacy</a> 
                                e prendi visione dell'informativa sul 
                                <a href="#">trattamento dei dati personali</a> di Maluburger 
                            </p>
                        </div>
                       
                    </div>
                        
                    </div>
                    

                    <div class="form-group">
                        <label class="control-label"></label>
                        <input type="submit" name="signup" value="Registrazione" class="submit">
                        
                    </div>

                </form>
            </div>

        </section>
        <?php include 'cart.php'; ?>
    </article>

    <?php include 'footer.php'; ?>
</body>

</html>

