<?php

use Core\Util\ErrorManager;
use Core\Util\SuccessManager;

?>

    <section id="section_win">

        <h1>Gagnééé !</h1>

        <?php
        foreach (SuccessManager::getMessages() as $message) : ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endforeach;
        SuccessManager::destroy();

        foreach (ErrorManager::getMessages() as $message) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $message ?>
            </div>
        <?php endforeach;
        ErrorManager::destroy();
        ?>

        <p>Vous avez gagné après <?= $pendu->getAttempts(); ?> tentative(s) dont <?= $pendu->getFailures(); ?> erreur(s).</p>

        <figure><img src="<?= 'imgs/bravo.gif'; ?>" alt="Bravo"></figure>

        <p>Que voulez-vous faire à présent ?</p>

        <p>
            <a href="?target=replay"><button class="btn btn-primary">Rejouer</button></a>
            <a href="?target=leave"><button class="btn btn-secondary">Quitter</button></a>
        </p>

        <audio controls>
            <source src="../sons/win.mp3" type="audio/mp3">
        </audio>

    </section>
