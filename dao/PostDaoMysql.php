<?php
require_once("models/Post.php");
require_once('dao/UserRelationDaoMysql.php');
require_once('dao/UserDaoMysql.php');

class PostDaoMysql implements PostDAO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

    }

    public function insert(Post $p)
    {
        $sql = $this->pdo->prepare("INSERT INTO posts (
            id_user, type, created_at, body

        ) VALUES (
            :id_user, :type, :created_at, :body

        )");
        $sql->bindValue(':id_user', $p->id_user);
        $sql->bindValue(':type', $p->type);
        $sql->bindValue(':created_at', $p->created_at);
        $sql->bindValue(':body', $p->body);
        $sql->execute();
    }

    public function getHomeFeed($id_user){
        $array = [];
        // 1. Lista de usuários que userlogado segue
        $userDao = new UserRelationDaoMysql($this->pdo);
        $userList = $userDao->getRelationsFrom($id_user);

        // 2. Posts ordenados pelas datas
        $sql = $this->pdo->query("SELECT * FROM posts WHERE id_user IN (".implode(',', $userList).") ORDER BY created_at DESC");
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            // 3. Transformar os resultados em objetos
            $array = $this->_postListToObject($data, $id_user);

        }
        return $array;
    }

    // Função auxiliar para transformar array em objeto
    private function _postListToObject($post_list, $id_user){
        $posts = [];
        $userDao = new UserDaoMysql($this->pdo);

        foreach ($post_list as $post_item) {
            $newPost = new Post();
            $newPost->id = $post_item['id'];
            $newPost->type = $post_item['type'];
            $newPost->created_at = $post_item['created_at'];
            $newPost->body = $post_item['body'];
            $newPost->mine = false;

            if ($post_item['id'] == $id_user) {
                $newPost->mine = true;
            }

            //Pegar informações do usuário
            $newPost->user = $userDao->findById($post_item['id_user']);

            // Informações sobre like
            $newPost->likeCount = 0;
            $newPost->liked = false;

            // Informações sobre comments
            $newPost->comments=[];

            $posts[] = $newPost;
            
        }

        return $posts;
    }
}
