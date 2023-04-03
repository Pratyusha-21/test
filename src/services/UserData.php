<?php
namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\User;
use App\Services\Otp;
use App\Entity\UserDetails as Users;
use App\Entity\Post;

/**
 * Gets all the post details and stores them in the database.
 */
class UserData {

    /**
    *  @var object
    *     object of Entity Manager Interface class.
    */
    private $em;

    /**
     * Constructor to assign the values to the class variables.
     */
    public function __construct($em) {
        $this->em = $em;
    }

    /**
     * Gets all the notes details stores them in the database.
     * 
     *   @return array $posts
     *     array of notes, name and id of the post.
     */
    public function postDetails() {
        $postData = $this->em->getRepository(Post::class)->findAll();
        $posts = [];
        //Traverse through all the posts in the main page and store post id, username, notes in an array.
        for ($i = count($postData)-1; $i >=0 ; $i--) {
            $id = $postData[$i]->getId();
            $name = $postData[$i]->getUsername();
            $post = $postData[$i]->getPost();
            $arr = [
                'id' => $id,
                'username' => $name,
                'post' => $post,
            ];
            array_push($posts, $arr);
        }
        return $posts;
    }
}