<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.04.2017
 * Time: 11:43
 */
class Model_registration extends Model
{
    public static $recapthaSecret = "6LdyPSQUAAAAAAuWnDT2vBYXIetZQ7pavcvWZbsX";

    private function recaptca(){
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
        if ($resp->isSuccess()) {
            // verified!
            // if Domain Name Validation turned off don't forget to check hostname field
            // if($resp->getHostName() === $_SERVER['SERVER_NAME']) {  }
        } else {
            $errors = $resp->getErrorCodes();
        }
    }

    public function get_data()
    {
        $dataBase =new DataBase();
        $main = new Main();
        $mail = new PHPMailer();
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


            $mail->SMTPDebug = 6;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";

            $mail->Host = "smtp.yandex.ru";
            $mail->Port = 587;
            $mail->Username = 'vasya.qa2018@yandex.ru';                 // SMTP username
            $mail->Password = 'qwerasdfzxcv';
            $mail->SetFrom("myemail@gmail.com");

            $mail->addAddress('xaam1@ya.ru', 'Илья Чубаров2');// Add a recipient
            $mail->Subject = "Requested link";
            $mail->Body = "Dear $name,\n\nYou have requested to reset your password .
                       \n\nTo reset your password, please click the link below.\n\n".$reset_url."\n\nThank you!";


            if(!$mail->send()) {
                $message .= 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $message .= 'Message has been sent';
            }

        } else {
            $message = 'Ошибка Не получилось добавить в базу ';
        }

        return $message;
    }
}