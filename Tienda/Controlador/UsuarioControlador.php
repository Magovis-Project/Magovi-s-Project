<?php

require_once(__DIR__ . '/../Models/UserModel.php');

class UserController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();

        // Incluir la vista y pasarle los datos
        include(__DIR__ . '/../../views/inicio.html');
    }
}
?>
