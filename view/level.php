<?php

use Core\Html\Form;

?>

<section id="section_level">

    <h1>Difficulté</h1>

    <p>Veuillez sélectionner la difficulté souhaitée.</p>

    <?php if ($form instanceof Form) : ?>

        <form class="form_start" action="?target=play" method="POST">

            <div>
                <?= $form->select('level', $levels = $pendu::LEVELS, 'Level :', 'Choose a level', ['required' => 'required']); ?>
            </div>

            <button class="btn btn-primary">Valider</button>

        </form>

    <?php endif; ?>

</section>
