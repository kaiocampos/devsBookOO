<?php
require_once('config.php');
require_once('models/Auth.php');
require_once('dao/UserDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$city = filter_input(INPUT_POST, 'city');
$work = filter_input(INPUT_POST, 'work');
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');

if ($name && $email) {
    // não precisam de verificação -  podem repetir no banco
    $userInfo->name = $name;
    $userInfo->city = $city;
    $userInfo->work = $work;

    //EMAIL
    if($userInfo->email != $email){
        if ($userDao->findByEmail($email) === false) {
            $userInfo->email = $email;
            
        }else{
            $_SESSION['flash'] = 'E-mail já existe!';
            header("Location:{$base}/configuracoes");
            exit;
        }
    }
    //BIRTHDATE
    $birthdate = explode('/', $birthdate);
    if (count($birthdate) != 3) {
        $_SESSION['flash'] = "Data de nascimento inválida";
        header("Location:{$base}/configuracoes.php");
        exit;
    }
    $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
    if (strtotime($birthdate) ===  false) {
        
        $_SESSION['flash'] = "Data de nascimento inválida";
        header("Location:{$base}/configuracoes.php");
        exit;
    
    }
    $userInfo->birthdate = $birthdate;

    //PASSWORD
    if(!empty($password)){
        if ($password === $password_confirmation) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userInfo->password = $hash;
            
        }else{
            $_SESSION['flash'] = 'As Senhas não são iguais';
            header("Location:{$base}/configuracoes");
            exit;
        }
    }

    $userDao->update($userInfo);
    
}
header("Location:{$base}/configuracoes.php");
exit;