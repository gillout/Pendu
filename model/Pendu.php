<?php

namespace Model;

/**
 * Class Pendu
 * @package Model
 */
class Pendu
{

    /**
     * Prénom du joueur
     * @var string $player
     */
    private $player;

    /**
     * Niveau de difficulté du jeu
     * @var int
     */
    private $level;

    /**
     * Mot actuel à trouver
     * @var string $word
     */
    private $word;

    /**
     * Etat du mot à trouver dont toutes les lettres n'ont pas encore été découvertes
     * @var string $state
     */
    private $state;

    /**
     * Chaine de caractères contenant toutes les lettres déjà essayées
     * @var string $lettersTried
     */
    private $lettersTried;

    /**
     * Nombre de lettres déjà indiquées
     * @var int $attempts
     */
    private $attempts;

    /**
     * Nombre d'échecs restants avant de perdre la partie
     * @var int $failures
     */
    private $failures;

    /**
     * Tableau des niveaux de difficultés, à déduire du nombre d'échecs maximum avant de perdre
     */
    const LEVELS = [3 => 'Facile', 6 => 'Moyenne', 9 => 'Difficile'];

    /**
     * Tableau contenant les différentes possibles
     */
    const LETTERS = ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E', 'f' => 'F', 'g' => 'G', 'h' => 'H',
        'i' => 'I', 'j' => 'J', 'k' => 'K', 'l' => 'L', 'm' => 'M', 'n' => 'N', 'o' => 'O', 'p' => 'P',
        'q' => 'Q', 'r' => 'R', 's' => 'S', 't' => 'T', 'u' => 'U', 'v' => 'V', 'w' => 'W', 'x' => 'X', 'y' => 'Y', 'z' => 'Z'];

    /**
     * Tableaux contenants les différents mots du dictionnaire du jeu
     */
    const WORDS4LETTERS = ['VELO', 'OURS', 'BLEU', 'NOEL', 'CHAT', 'SOIF', 'LOTO', 'PILE', 'FAIM', 'GITE'];
    const WORDS5LETTERS = ['AVION', 'FLEUR', 'MELON', 'ROUGE', 'DINER', 'POMME', 'SALON', 'COEUR', 'NEIGE', 'LAPIN'];
    const WORDS6LETTERS = ['ANANAS', 'MANGER', 'ORANGE', 'MAISON', 'BILLES', 'SOLEIL', 'VIOLET', 'PAPIER', 'ETOILE', 'PECHER'];
    const WORDS7LETTERS = ['VOITURE', 'BALEINE', 'CADEAUX', 'BOUTONS', 'CHATEAU', 'LUMIERE', 'PISCINE', 'FRAISES', 'GUITARE', 'CHAMBRE'];
    const WORDS8LETTERS = ['PAPILLON', 'CUISINER', 'POUBELLE', 'BRACELET', 'GOURMAND', 'FEUILLES', 'HISTOIRE', 'CONDUIRE', 'DEJEUNER', 'PANTHERE'];
    const WORDS9LETTERS = ['TELEPHONE', 'CROCODILE', 'PROLONGER', 'DINOSAURE', 'BOUTEILLE', 'SERVIETTE', 'FRAMBOISE', 'SUPPORTER', 'RESPECTER'];
    const WORDS10LETTERS = ['ELASTIQUES', 'ETIQUETTES', 'TELEVISION', 'ORDINATEUR', 'SEDUISANTE', 'OPERATRICE', 'CONCLUSION', 'APESANTEUR'];
    const WORDS11LETTERS = ['PHOTOGRAPHIE', 'DECORATIONS', 'DESORDONNER', 'HIPPOPOTAME', 'DECHIQUETER', 'EMPOISONNER', 'USUELLEMENT'];
    const WORDS12LETTERS = ['ORGANISATION', 'ASTRONOMIQUE', 'APPARTENANCE', 'TRANQUILLITE', 'DESAVANTAGER', 'FROISSEMENTS'];
    const WORDS13LETTERS = ['DEVELOPPEMENT', 'REEQUILIBRAGE', 'FONCTIONNAIRE', 'ATTENDRISSANT', 'TRANSFORMABLE'];
    const WORDS14LETTERS = ['HUMIDIFICATION', 'CORRESPONDANCE', 'NUTRITIONNISTE', 'DEMATERIALISER'];

    /**
     * Pendu constructor.
     */
    public function __construct()
    {
        $this->player = '';
        $this->level = 0;
        $this->word = '';
        $this->state = '';
        $this->lettersTried = '';
        $this->attempts = 0;
        $this->failures = 0;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }

    /**
     * @param string $player
     */
    public function setPlayer(string $player): void
    {
        $this->player = $player;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = $word;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getLettersTried(): string
    {
        return $this->lettersTried;
    }

    /**
     * @param string $lettersTried
     */
    public function setLettersTried(string $lettersTried): void
    {
        $this->lettersTried = $lettersTried;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * @return int
     */
    public function getFailures(): int
    {
        return $this->failures;
    }

    /**
     * @param int $failures
     */
    public function setFailures(int $failures): void
    {
        $this->failures = $failures;
    }

    /**
     * Fusionne tous les tableaux de mots
     * @return array
     */
    public function mergeAllTabWords(): array
    {
        return array_merge(self::WORDS4LETTERS, self::WORDS5LETTERS,self::WORDS6LETTERS,
            self::WORDS7LETTERS, self::WORDS8LETTERS, self::WORDS9LETTERS, self::WORDS10LETTERS,
            self::WORDS11LETTERS, self::WORDS12LETTERS, self::WORDS13LETTERS, self::WORDS14LETTERS);
    }

    /**
     * Sélectionne un mot au hazard parmis tous les tableaux de mots
     * @return void
     */
    public function randomWord(): void
    {
        $allWords = $this->mergeAllTabWords();
        $randowKey = array_rand($allWords,1);
        $word = $allWords[$randowKey];
        $this->setWord($word);
    }

    /**
     * Génére l'état de départ du mot à trouver en fonction de sa taille
     * Si la taille du mot est inférieure ou égale à 7 alors toutes les lettres sont remplacées par le caractère "_"
     * Si la taille du mot est inférieure ou égale à 11 alors on affiche la première lettre et toutes les autres sont remplacées par le caractère "_"
     * Si la taille du mot est supérieure à 11 on affiche la première et la dernière lettre, puis toutes les autres sont remplacées par le caractère "_"
     * @return void
     */
    public function startingState(): void
    {
        $len = strlen($this->getWord());
        if ($len <= 7) {
            $this->setState(str_pad('', $len, '_'));
        } else if ($len <= 11) {
            $this->setState(str_pad($this->getWord()[0], $len, '_'));
        } else {
            $this->setState((str_pad($this->getWord()[0], $len - 1, '_')) . $this->getWord()[$len - 1]);
        }
    }

    /**
     * Incrémente le nombre de tentatives pour chaque lettre entrée
     * @return void
     */
    public function incrementAttempts(): void
    {
        $this->attempts++;
    }

    /**
     * Décrémente le nombre d'echecs restants pour chaque lettre entrée n'existant pas dans le mot à trouver
     * @return void
     */
    public function decrementFailures(): void
    {
        $this->failures--;
    }

    /**
     * Vérifie si la lettre est présente dans le mot à trouver
     * @param string $letter
     * @return bool
     */
    public function letterPresent(string $letter): bool
    {
        return (strpos($this->getWord(), $letter)) !== false;
    }

    /**
     * Remplace le caractère "_" par la bonne lettre dans le mot en cours de découverte
     * @param string $letter
     */
    public function addLetter(string $letter): void
    {
        $word = $this->getWord();
        $state = $this->getState();
        for ($i = 0; $i < strlen($word); $i++) {
            if ($word[$i] == $letter) {
                $state[$i] = $letter;
            }
        }
        $this->setState($state);
    }

}