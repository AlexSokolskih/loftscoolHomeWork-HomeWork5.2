<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.04.2017
 * Time: 11:43
 */
class Model_registration extends Model
{
    public function get_data()
    {
        $dataBase =new DataBase();
        $main = new Main();
        $password1 = '';
        $password2 = '';
        $newLogin = '';

        if (isset($_POST['password1'])) {
            $password1 = htmlspecialchars($_POST['password1']);
            $criptPassword = $main->cpyptPassword($password1);
        }
        if (isset($_POST['password2'])) {
            $password2 = htmlspecialchars($_POST['password2']);
        }
        if (isset($_POST['newLogin'])) {
            $newLogin = htmlspecialchars($_POST['newLogin']);
        }


        if ($password1 !== $password2) {
            $message = 'Ошибка введенные пароли не совпадают ';
        } elseif ($dataBase->is_userInDataBase($newLogin)) {
            $message = 'Ошибка Такой пользователь существует ';
        } elseif ($newLogin == '' or $password1 == '') {
            $message = 'Ошибка Пустое поле ';
        } elseif ($dataBase->saveNewUser($newLogin, $criptPassword)) {
            $message = 'Добавлен успешно';
        } else {
            $message = 'Ошибка Не получилось добавить в базу ';
        }

        return $message;
    }
}