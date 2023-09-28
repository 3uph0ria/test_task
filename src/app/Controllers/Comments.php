<?php

namespace App\Controllers;
use \App\Models\Comments_model;

class Comments extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new \App\Models\Comments_model();
    }

    public function index()
    {
        $data = [
            'Comments' =>  $this->model->findAll()
        ];

        return view('Comments/index.php', $data);
    }

    public function getData()
    {
        $data = [
            'Comments' =>  $this->model->findAll()
        ];

        return view('Comments/data.php', $data);
    }

    public function store()
    {
        $result = $this->model->insert(
            [
                'Name' => $this->request->getPost('Name'),
                'Text' => $this->request->getPost('Text'),
                'Date' => $this->request->getPost('Date')

            ]
        );

        if(!$result)
            $_SESSION['errors'] = $this->model->errors();
        else
            $_SESSION['success'] = 'Комментарий успешно добавлен!';
    }

    public function delete()
    {
        $result = $this->model->delete($this->request->getGet('Id'));

        if(!$result)
            $_SESSION['errors'] = $this->model->errors();
        else
            $_SESSION['success'] = 'Комментарий успешно удален!';
    }


}