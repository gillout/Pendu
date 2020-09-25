<?php

namespace Manager;

use Model\Pendu;

class PenduManager
{

    /**
     * PenduManager constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return Pendu
     */
    public function find(): Pendu
    {
        $pendu = new Pendu();
        $pendu->setPlayer(array_key_exists('player', $_SESSION) ? $_SESSION['player'] : '');
        $pendu->setLevel(array_key_exists('level', $_SESSION) ? $_SESSION['level'] : 0);
        $pendu->setWord(array_key_exists('word', $_SESSION) ? $_SESSION['word'] : '');
        $pendu->setState(array_key_exists('state', $_SESSION) ? $_SESSION['state'] : '');
        $pendu->setLettersTried(array_key_exists('lettersTried', $_SESSION) ? $_SESSION['lettersTried'] : '');
        $pendu->setAttempts(array_key_exists('attempts', $_SESSION) ? $_SESSION['attempts'] : 0);
        $pendu->setFailures(array_key_exists('failures', $_SESSION) ? $_SESSION['failures'] : 0);
        return $pendu;
    }

    /**
     * @param Pendu $pendu
     * @return void
     */
    public function save(Pendu $pendu): void
    {
//        $_SESSION['pendu'] = (array) $pendu;
        $_SESSION['player'] = $pendu->getPlayer();
        $_SESSION['level'] = $pendu->getLevel();
        $_SESSION['word'] = $pendu->getWord();
        $_SESSION['state'] = $pendu->getState();
        $_SESSION['lettersTried'] = $pendu->getLettersTried();
        $_SESSION['attempts'] = $pendu->getAttempts();
        $_SESSION['failures'] = $pendu->getFailures();
    }

}