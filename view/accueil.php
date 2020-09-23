<?php

use Core\Html\Form;

?>

<section id="section_accueil">

    <h1><strong>Bienvenue</strong></h1>

    <p>Afin d'accéder au jeu, veuillez entrer votre prénom.</p>

    <?php if ($form instanceof Form) : ?>

        <form class="form_accueil" action="?target=start" method="POST">

            <div>
                <?= $form->input('playerName', 'Prénom :', ['required' => 'required']); ?>
            </div>

            <button class="btn btn-info">Valider</button>

        </form>

    <?php endif; ?>

</section>