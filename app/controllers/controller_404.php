<?php

class Controller_404 extends Controller
{

    public function action_index()
    {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');

        $this->view->generate('base_view.twig',
            [
                 'title' => 'Ошибка 404!',
                'content' => 'Данной страницы не существует!!!'
            ]);
    }

}
