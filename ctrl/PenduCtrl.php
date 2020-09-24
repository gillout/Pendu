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
        $this->render(ROOT_DIR . 'view/accueil.php', compact('form'));
    }

    /**
     * Créé un nouveau jeu de pendu avec le nom du joueur et le niveau de difficulté
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
        $pendu->setState(str_pad('', strlen($pendu->getWord()), '_'));
        $pendu->setFailures(12 - $level);
        $this->PenduManager->save($pendu);
        $form = new Form();
        $this->render(ROOT_DIR . 'view/play.php', compact('form', 'pendu'));
    }

    public function replay()
    {
        $pendu = $this->PenduManager->find();
        $this->newGame($pendu->getPlayer(), $pendu->getLevel());
    }

    /**
     * Affiche la page principale du jeu, c'est là qu'une lettre est entrée
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
            $tentatives = $pendu->getAttempts();
            $tentatives++;
            $pendu->setAttempts($tentatives);
            if ($pendu->letterPresent($letter)) {
                $pendu->addLetter($letter);
                $this->PenduManager->save($pendu);
                if ($pendu->getWord() == $pendu->getState()) {
                    $this->win($pendu);
                }
            } else {
                $failures = $pendu->getFailures();
                $failures--;
                $pendu->setFailures($failures);
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