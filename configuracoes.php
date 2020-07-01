<?php
require_once('config.php');
require_once('models/Auth.php');
require_once('dao/UserDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'config';

$userDao = new UserDaoMysql($pdo);

require_once("partials/header.php");
require_once("partials/menu.php");

?>

<section class="feed mt-10">
    <h1>Configurações</h1>

    <form action="configuracoes_action.php" enctype="multipart/form-data" method="post" class="config-form">
    <label>
        Novo Avatar:
        <input type="file" name="avatar"><br>
        <img class="mini" src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>"/>
    </label>
    <label>
        Nova Capa:
        <input type="file" name="cover"><br>
        <img class="mini" src="<?=$base;?>/media/covers/<?=$userInfo->cover;?>"/>
    </label>
    <hr>
    <label>
        Nome Completo:<br>
        <input type="text" name="name" value="<?=$userInfo->name;?>">
    </label>
    
    <label>
        Email:<br>
        <input type="email" name="email" value="<?=$userInfo->email;?>">
    </label>

    <label>
        Data de Nascimento:<br>
        <input type="text" name="birthdate" id="birthdate" value="<?=date('d/m/Y', strtotime($userInfo->birthdate));?>">
    </label>

    <label>
        Cidade:<br>
        <input type="text" name="city" value="<?=$userInfo->city;?>">
    </label>

    <label>
        Trabalho:<br>
        <input type="text" name="work" value="<?=$userInfo->work;?>">
    </label>
    <hr>

    <label>
        Nova Senha:<br>
        <input type="password" name="password">
    </label>
    <label>
        Confirmar Nova Senha:<br>
        <input type="password" name="password_confirmation">
    </label>

    <button class="button">Salvar</button>

    </form>
</section>
<script src="https://unpkg.com/imask"></script>
    <script>
        IMask(
            document.getElementById('birthdate'),
            {mask:'00/00/0000'}
        );
    </script>
<?php require_once("partials/footer.php"); ?>