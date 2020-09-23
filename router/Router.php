<?php

namespace Router;


use Core\Html\Form;
use Ctrl\PenduCtrl;


class Router
{
    /**
     * @var array
     */
    private $params;

    /**
     * RouterNew constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function route(): void
    {
        if (isset($this->params['target'])) {
            switch ($this->params['target']) {
                case 'home':
                    $this->home();
                    break;
                case 'start':
                    $this->start();
                    break;
                case 'play':
                    $this->play();
                    break;
                case 'replay':
                    $this->replay();
                    break;
                case 'leave':
                    $this->leave();
                    break;
                default:
                    $this->notFound();
            }
        } else {
            $this->home();
        }
    }

    private function home(): void
    {
        $ctrl = new PenduCtrl();
        $form = new Form();
        $ctrl->home($form);
    }

    private function start(): void
    {
        $ctrl = new PenduCtrl();
        $form = new Form($_POST);
        $ctrl->start($form);
    }

    private function play(): void
    {
        $ctrl = new PenduCtrl();
        $form = new Form($_POST);
        $ctrl->play($form);
    }

    private function replay(): void
    {
        $ctrl = new PenduCtrl();
        $form = new Form();
        $ctrl->start($form);
    }

    private function leave(): void
    {
        $ctrl = new PenduCtrl();
        $ctrl->leave();
    }

    private function notFound(): void
    {
        (new PenduCtrl())->notFound();
    }

}