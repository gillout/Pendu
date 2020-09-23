<?php

use Core\Html\Form;

?>

<section id="section_start">

    <h2><strong>Bonjour <?= $_SESSION['player']; ?></strong></h2>

    <p>Veuillez entrer le nombre de lettres du mot à trouver.</p>

    <?php if (isset($form)) {

        if ($form instanceof Form) : ?>

            <form class="form_start" action="?target=size" method="POST">

                <div>
                    <?= $form->input('length', 'Nombre de lettres :', ['required' => 'required']); ?>
                </div>

                <button class="btn btn-info">Valider</button>

            </form>

        <?php endif;

    } ?>

</section>
