<?php
require_once('models/PostLike.php');

class PostLikeDaoMysql implements PostLikeDAO{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLikeCount($id_post){
        $sql = $this->pdo->prepare("SELECT COUNT(*) as qtLikes FROM postlikes WHERE id_post = :id_post ");
        $sql->bindValue(':id_post', $id_post);
        $sql->execute();

        $data = $sql->fetch();
        return $data['qtLikes'];
    }

    public function isLiked($id_post, $id_user){
        $sql = $this->pdo->prepare("SELECT * FROM postlikes WHERE id_post = :id_post AND id_user = :id_user");
        $sql->bindValue(':id_post', $id_post);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        }else{
            return false;
        }


    }

    public function likeToggle($id_post, $id_user){
        if ($this->isLiked($id_post, $id_user)) {
            $sql = $this->pdo->prepare("DELETE FROM postlikes WHERE id_post = :id_post AND id_user = :id_user");
            // $sql->bindValue(':id_post', $id_post);
            // $sql->bindValue(':id_user', $id_user);
            // $sql->execute();
        }else{
            $sql = $this->pdo->prepare("INSERT INTO postlikes (id_post, id_user, created_at) VALUES (:id_post, :id_user, NOW())");
            // $sql->bindValue(':id_post', $id_post);
            // $sql->bindValue(':id_user', $id_user);
            // $sql->execute();
        }
        // Para simplificar o código retira-se de dentro dos condicionais e põe fora, visto que os valores sao os mesmo
        $sql->bindValue(':id_post', $id_post);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();
    }

}