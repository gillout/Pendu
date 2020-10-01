<?php

namespace Ctrl;

use Core\Ctrl\Controller;
use Core\Html\Form;
use Manager\PenduManager;
use Model\Pendu;

/**
 * Class PenduCtrl
 * @package Ctrl
 */
class PenduCtrl extends Controller
{
    /**
     * @var PenduManager
     */
    private $PenduManager;

    /**
     * PenduCtrl constructor.
     * @param string $template
     */
    public function __construct(string $template = ROOT_DIR . 'view/template.php')
    {
        $this->PenduManager = new PenduManager();
        parent::__construct($template);
    }

    /**
     * Affiche la page d'accueil
     * @param $form
     * @return void
     */
    public function home(Form $form): void
    {
        if (array_key_exists('player', $form->getDatas())) {
            $form->add('player', $form->getValue('player'));
        }
        $this->render(ROOT_DIR . 'view/accueil.php', compact('form'));
    }

    /**
     * Crée un nouveau jeu de pendu avec le nom du joueur et le niveau de difficulté
     * @param string $player
     * @param int $level
     * @return void
     */
    public function newGame(string $player, int $level): void
    {
        $pendu = new Pendu();
        $pendu->setPlayer($player);
        $pendu->setLevel($level);
        $pendu->randomWord();
        $pendu->startingState();
        $pendu->setFailures(12 - $pendu->getLevel());
        $this->PenduManager->save($pendu);
        $form = new Form();
        $this->render(ROOT_DIR . 'view/play.php', compact('form', 'pendu'));
    }

    /**
     * Affiche la page principale du jeu, c'est là qu'une lettre est attendue
     * @param Form $form
     * @return void
     */
    public function play(Form $form): void
    {
        $pendu = $this->PenduManager->find();
        $letter = strtoupper($form->getValue('letter'));
        $tried = ' ' . $pendu->getLettersTried() . $letter . ' ';
        $pendu->setLettersTried($tried);
        if ($letter != null && $letter != '' && $letter != ' ') {
            $pendu->incrementAttempts();
            if ($pendu->letterPresent($letter)) {
                $pendu->addLetter($letter);
                $this->PenduManager->save($pendu);
                if ($pendu->getWord() == $pendu->getState()) {
                    $this->win($pendu);
                }
            } else {
                $pendu->decrementFailures();
                $this->PenduManager->save($pendu);
                if ($pendu->getFailures() < 0) {
                    $this->loose($pendu);
                }
            }
        }
        $form = new Form();
        $this->render(ROOT_DIR . 'view/play.php', compact('form', 'pendu'));
    }

    /**
     * Affiche la pag principale du jeu avec un nouveau mot, et garde le nombre d'échecs ainsi que le nombre de lettres déjà essayées
     * @return void
     */
    public function newWord(): void
    {

        $pendu = $this->PenduManager->find();
        $pendu->randomWord();
        $pendu->startingState();
        $pendu->setLettersTried('');
        $this->PenduManager->save($pendu);
        $form = new Form();
        $this->render(ROOT_DIR . 'view/play.php', compact('form', 'pendu'));
    }

    /**
     * Renvoi sur la page d'accueil avec le nom déjà renseigné
     * @return void
     */
    public function replay(): void
    {
        $pendu = $this->PenduManager->find();
        $form = new Form();
        $form->add('player', $pendu->getPlayer());
        $this->home($form);
    }

    /**
     * Envoi vers la page du gagnant
     * @param Pendu $pendu
     * @return void
     */
    public function win(Pendu $pendu): void
    {
        $this->render(ROOT_DIR . 'view/win.php', compact('pendu'));
    }

    /**
     * Envoi vers la page du perdant
     * @param Pendu $pendu
     * @return void
     */
    public function loose(Pendu $pendu): void
    {
        $this->render(ROOT_DIR . 'view/loose.php', compact('pendu'));
    }

    /**
     * Envoi vers la page d'accueil après avoir fermé la session
     * @return void
     */
    public function leave(): void
    {
        session_destroy();
        $form = new Form();
        $this->home($form);
    }

    /**
     * Renvoi vers la page lorsqu'une ressource n'a pas été trouvée
     * @return void
     */
    public function notFound(): void
    {
        $this->render(ROOT_DIR . 'view/not_found.php', []);
    }

}