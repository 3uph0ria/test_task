<?php
namespace App\Models;
use CodeIgniter\Model;
class Comments_model extends Model
{
    protected $table = 'Comments';
    protected $allowedFields = ['Id', 'Name', 'Text', 'Date'];
    protected $useTimestamps = false;
    protected $DBGroup = 'default';

    protected $validationRules = [
        'Name' => 'required|valid_email',
        'Text' => 'required',
        'Date' => 'required'
    ];

    protected  $validationMessages = [
        'Name' => [
            'required' => 'Укажите Email',
            'valid_email' => 'Укажите корректный Email, например test@mail.ru'
        ]
    ];

}