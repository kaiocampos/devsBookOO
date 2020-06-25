<?php
require_once('config.php');
require_once('models/Auth.php');
require_once('dao/UserRelationDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'home';

// 1. Lista de usuários que userlogado segue
$userDao = new UserRelationDaoMysql($pdo);
$userList = $userDao->getRelationsFrom($userInfo->id);

// 2. Posts ordenados pelas datas
// 3. Transformar os resultados em objetos

require_once("partials/header.php");
require_once("partials/menu.php");

?>

<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">

            <?php require_once("partials/feed-editor.php");?>

            <!-- <div class="box feed-item">
                <div class="box-body">
                    <div class="feed-item-head row mt-20 m-width-20">
                        <div class="feed-item-head-photo">
                            <a href=""><img src="media/avatars/avatar.jpg" /></a>
                        </div>
                        <div class="feed-item-head-info">
                            <a href=""><span class="fidi-name">Bonieky Lacerda</span></a>
                            <span class="fidi-action">fez um post</span>
                            <br />
                            <span class="fidi-date">07/03/2020</span>
                        </div>
                        <div class="feed-item-head-btn">
                            <img src="assets/images/more.png" />
                        </div>
                    </div>
                    <div class="feed-item-body mt-10 m-width-20">
                        Pessoal, tudo bem! Busco parceiros para empreender comigo em meu software.<br /><br />
                        Acabei de aprová-lo na Appstore. É um sistema de atendimento via WhatsApp multi-atendentes para auxiliar empresas.<br /><br />
                        Este sistema permite que vários funcionários/colaboradores da empresa atendam um mesmo número de WhatsApp, mesmo que estejam trabalhando remotamente, sendo que cada um acessa com um login e senha particular....
                    </div>
                    <div class="feed-item-buttons row mt-20 m-width-20">
                        <div class="like-btn on">56</div>
                        <div class="msg-btn">3</div>
                    </div>
                    <div class="feed-item-comments">

                        <div class="fic-item row m-height-10 m-width-20">
                            <div class="fic-item-photo">
                                <a href=""><img src="media/avatars/avatar.jpg" /></a>
                            </div>
                            <div class="fic-item-info">
                                <a href="">Bonieky Lacerda</a>
                                Comentando no meu próprio post
                            </div>
                        </div>

                        <div class="fic-item row m-height-10 m-width-20">
                            <div class="fic-item-photo">
                                <a href=""><img src="media/avatars/avatar.jpg" /></a>
                            </div>
                            <div class="fic-item-info">
                                <a href="">Bonieky Lacerda</a>
                                Muito legal, parabéns!
                            </div>
                        </div>

                        <div class="fic-answer row m-height-10 m-width-20">
                            <div class="fic-item-photo">
                                <a href=""><img src="media/avatars/avatar.jpg" /></a>
                            </div>
                            <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
                        </div>

                    </div>
                </div>
            </div> -->



        </div>
        <div class="column side pl-5">
            <div class="box banners">
                <div class="box-header">
                    <div class="box-header-text">Patrocinios</div>
                    <div class="box-header-buttons">

                    </div>
                </div>
                <div class="box-body">
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                    <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                </div>
            </div>
            <div class="box">
                <div class="box-body m-10">
                    Criado com ❤️ por B7Web
                </div>
            </div>
        </div>
    </div>

</section>

<?php require_once("partials/footer.php"); ?>