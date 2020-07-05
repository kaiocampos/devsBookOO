<?php
require_once('config.php');
require_once('models/Auth.php');
require_once('dao/UserRelationDaoMysql.php');
require_once('dao/UserDaoMysql.php');

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $userRelationDAo = new UserRelationDaoMysql($pdo);
    $userDao =  new UserDaoMysql($pdo);

    
    if ($userDao->findById($id)) {
        
        $relation = new UserRelation();
        $relation->user_from = $userInfo->id;
        $relation->user_to = $id;
    
        if ($userRelationDAo->isFollowing($userInfo->id, $id)) {
            
            $userRelationDAo->delete($relation);
                        
        }else{
            
            $userRelationDAo->insert($relation);
        }

        header("Location:perfil.php?id={$id}");
        exit;
    }
}

header("Location:{$base}");
exit;