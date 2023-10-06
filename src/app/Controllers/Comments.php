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

        $field = $this->request->getPost('fieldSort');
        $type = $this->request->getPost('typeSort');

        $data = $this->getData($field, $type);

        return view('Comments/index.php', $data);
    }


    public function store()
    {
        $result = $this->model->insert
        (
            [
                'Name' => $this->request->getPost('Name'),
                'Text' => $this->request->getPost('Text'),
                'Date' => $this->request->getPost('Date')
            ]
        );

        if(!$result)
        {
            $data = [
                'success' => false,
                'message' => implode(' | ', $this->model->errors()),
            ];
            return $this->response->setJSON($data);
        }
        else
        {
            $data = [
                'success' => true,
                'message' => 'Комментарий успешно добавлен!',
            ];
            return $this->response->setJSON($data);
        }
    }

    public function delete()
    {
        $result = $this->model->delete($this->request->getGet('Id'));

        if(!$result)
        {
            $data = [
                'success' => false,
                'message' => implode(' | ', $this->model->errors()),
            ];
            return $this->response->setJSON($data);
        }
        else
        {
            $data = [
                'success' => true,
                'message' => 'Комментарий успешно удален!',
            ];
            return $this->response->setJSON($data);
        }
    }

    public function getData($field, $type)
    {
        if(isset($field) && isset($type))
        {
            $data = [
                'sort' => ['fieldSort' => $field, 'typeSort' => $type],
                'comments' => $this->model->SortCpmments($field, $type)->paginate(),
                'pager' => $this->model->pager
            ];
        }
        else
        {
            $data = [
                'sort' => ['fieldSort' => 'ID', 'typeSort' => 'DESC'],
                'comments' => $this->model->paginate(),
                'pager' => $this->model->pager
            ];
        }

        return $data;
    }

}