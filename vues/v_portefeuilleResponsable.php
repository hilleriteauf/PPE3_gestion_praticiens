
<main>
    <h1>PorteFeuille</h1>

    <a class='bouton centered' href='index.php?uc=praticiens&ucp=portefeuilleResponsable&action=ajouterPortefeuille'>Ajouter une relation</a>

    <form class="centered text-align" action="index.php?uc=praticiens&ucp=portefeuilleResponsable&action=afficherPortefeuille" method="post">
    <table class="tableau">
            <tr>
                <th>Matricule visiteur</th>
                <th>Nom praticien</th>
                <th>Région</th>
                <th></th>
                <th></th>
            </tr> 
        <?php

        foreach( $leportefeuille as $relations)
        {
            $matricule = $relations['matricule'];
            $nom = $relations['nom'];
            $region = $relations['reg_code'];
            $idspecialite = $relations['idspecialite'];
            $idPraticien = $relations['idPraticien'];
        
            ?>
            <tr>
                <td><?php echo $matricule ?></a></td>
                <td><?php echo $nom ?></td>
                <td><?php echo $region ?></td>
                

                <td><a href=index.php?uc=praticiens&ucp=portefeuilleResponsable&action=modification&matricule=<?php echo $matricule ?>&idPraticien=<?php echo $idPraticien ?>&idspecialite=<?php echo $idspecialite?>><img class="bouton_image" src="./images/modification.png" title="Ajout"></a></td>
                <td><a href=index.php?uc=praticiens&ucp=portefeuilleResponsable&action=supprimerPortefeuille&matricule=<?php echo $matricule ?>&idPraticien=<?php echo $idPraticien ?>&idspecialite=<?php echo $idspecialite?>><img class="bouton_image" src="./images/delete.png" title="Suppr"></a></td>
            </tr>
            <?php 
        }
        ?>
	</form>
    </div>
	
</main>