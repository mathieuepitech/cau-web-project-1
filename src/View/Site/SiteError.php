<?php if(!empty($_SESSION['ville_inconue']) && $_SESSION['ville_inconue'] == true){ ?>

    <div class="content">
        <div class="error-page-container">
            <div class="error-title"><?= $erreur ?></div>
            <div class="error-message">La ville saisie est introuvable</div>
            <div class="error-prestations">
                Merci d'effectuer une nouvelle recherche avec une autre ville en utilisant les suggestions de la liste.<br><br>
                Que voulez-vous faire ?<br><br>
                <a class="error-prestation" href="/ajout-artisan-avis">Evaluer un professionnel</a>
                <a class="error-prestation" href="/demande-devis">Demander des devis</a>
            </div>
        </div>
    </div>

<?php }else{ ?>

    <div class="content">
        <div class="error-page-container">
            <div class="error-title"><?= $erreur ?></div>
            <div class="error-message">Que voulez-vous faire ?</div>
            <div class="error-prestations">
                <a class="error-prestation" href="/ajout-artisan-avis">Evaluer un professionnel</a>
                <a class="error-prestation" href="/demande-devis">Demander des devis</a>
            </div>
        </div>
    </div>

<?php } ?>