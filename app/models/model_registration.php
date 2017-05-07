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
/*
            $mail->SMTPDebug = 3;

            $mail->isSMTP();                                    // Set mailer to use SMTP
            $mail->CharSet ='UTF-8';
            $mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'xaam1@yandex.ru';                 // SMTP username
            $mail->Password = '159SokolSila';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;
            $mail->setLanguage('ru');


            $mail->setFrom('xaam1@ya.ru', 'qqqqqqq');
            $mail->addAddress('xaam1@ya.ru', 'Joe User');     // Add a recipient



                                       // Set email format to HTML

            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

*/
            $mail->SMTPDebug = 6;
            $mail->isSMTP();                                             // Set mailer to use SMTP
            $mail->CharSet  = 'UTF-8';
            $mail->SMTPOptions = [ 'ssl' => [ 'verify_peer' => false ] ];

            $mail->Host       = 'smtp.yandex.ru';   // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
            $mail->Username   = 'loft.loft2018@yandex.ru';                      // SMTP username
            $mail->Password   = '3kfn44lnd442K';                                // SMTP password
            $mail->SMTPSecure = 'ssl';                                   // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 465;                                     // TCP port to connect to
            $mail->setLanguage('ru');

            $mail->setFrom('loft.loft2018@yandex.ru', 'Из курса по PHP');
            $mail->addAddress('agoalofalife@gmail.com', 'Илья Чубаров');
            $mail->addAddress('xaam1@ya.ru', 'Илья Чубаров2');// Add a recipient


//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Это будет в превью';
            $mail->Body    = 'Если HTML включен будет  <b>жирным!</b>';
            $mail->AltBody = 'Если клиент не поддерживает HTML';

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