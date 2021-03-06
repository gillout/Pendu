<?php

use Core\Html\Form;
use Model\Pendu;

?>

<section id="section_accueil">

    <h1><strong>Bienvenue</strong></h1>

    <p>Afin d'accéder au jeu, veuillez entrer votre prénom,</p>

    <p>ainsi que sélectionner un niveau de difficulté.</p>

    <?php if ($form instanceof Form) : ?>

        <form class="form_accueil" action="?target=start" method="POST">

            <div>
                <?= $form->input('player', 'Prénom :', ['required' => 'required']); ?>
            </div>

            <div>
                <?= $form->select('level', Pendu::LEVELS, 'Difficulté :', 'Choose a level', ['required' => 'required']); ?>
            </div>

            <button class="btn btn-primary">Valider</button>

        </form>

    <?php endif; ?>

</section>