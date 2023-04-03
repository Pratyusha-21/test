<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\User;
use App\Services\Otp;
use App\Services\UserData;
use App\Entity\UserDetails as Users;
use App\Entity\Post;

/**
 * Stores the details of the user in the database when the user signup.
 * Sends otp or link to the user.
 * Checks whether the otp is correct or not at time of signup and updates the otp in the database.
 * At the time of login checks whether the email exists or not and checks the password of the user.
 * Sends otp or link to the user for signup or setting new password.
 * For edit profile gets the name, email and username of the user and shows them in the field.
 * After editing profile gets the name, email and username of the user and stores them in the database.
 * Add new notes created by the user.
 * Delete notes created by the user.
 * Edit notes created by the user
 * Show notes in a list.
 */
class MainController extends AbstractController
{
        
    /**
     *   @var object 
     *     Stores the object of Entity Manager Interface Class.
     */
    private $em;
    /**
     *   @var string
     *     stores the sender's mail.
     */
    private $mailUserName;
    /**
     *   @var string
     *     Stores the sender's mail password.
     */
    private $mailPassword;
    /**
     *   @var object 
     *     Sets the object of UserDetails entity.
     */
    private $userDetails;
    /**
     *   @var object 
     *     Sets the object of Post entity.
     */
    private $post;

    /**
     *  Sets the mail username and password from the env file.
     * 
     *   @param object $em
     *     object of EntityManagerInterface instance.
     */
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->userDetails = $em->getRepository(Users::class);
        $this->post = $em->getRepository(Post::class);
        $this->mailUserName = $_ENV['mail_username'];
        $this->mailPassword = $_ENV['mail_password'];
    }

    /**
     * Route is used for main.
     */
    #[Route('/main', name: 'main')]
    public function main(): Response
    {
        return $this->render("main/index.html.twig");
    }

    /**
     * Shows the signup form.
     */
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render("signup/index.html.twig");
    }

    /**
     * This function will get the user details inputted in the form and store them in userDetails table.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return response 
     *     returns to the login page with the message if any.   
     */
    #[Route('/signup', name: 'signup')]
    public function signup(Request $rq): Response
    {
        $fn = $rq->get("name");
        $un = $rq->get("username");
        $mail = $rq->get("email");
        $otp = $rq->get("otp");
        $pswd = $rq->get("pswd");
        $user = $this->userDetails->findOneBy(['Email' => $mail]);
        $checkOtp = $user->getOtp();
        if ($checkOtp != $otp) {
            return $this->render("signup/index.html.twig",[
                "message" => "Incorrect Otp"
            ]);
        }
        $obj = new User($fn, $un, $mail, $pswd, $otp, $this->em);
        $msg = $obj->validateForm();
        if ($msg == "valid") {
            $obj->userDetails();
        }
        return $this->render("login/index.html.twig",[
            "message" => $msg
        ]);
    }

    /**
     * Gets the email address and generate an OTP and sent it to the recipient.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return response
     *     returns a message whether the OTP was sent successfully.
     */
    #[Route('/sendOtp', name: 'sendOtp')]
    public function sendOtp(Request $rq): Response
    {
        $email = $rq->get('emailid');
        $otp = random_int(100000,999999);
        $user = $this->userDetails->findOneBy(['Email' => $email]);
        if ($user == null) {
            $user = new Users();
            $user->setEmail($email);
            $user->setOtp($otp);
            $this->em->persist($user);
            $this->em->flush();
        }
        else {
            $user->setOtp($otp);
            $this->em->persist($user);
            $this->em->flush();
        }
        $obj = new Otp($this->mailUserName, $this->mailPassword);
        return new Response($obj->sendMail($email, $otp, "send"));
    }

    /**
     * Shows the login form.
     * 
     *   @param object $si
     *     object of class SessionInterface.
     * 
     *   @return Response
     *      if any value is stored in the session then returns to the main page or returns to the login page.
     */
    #[Route('/login', name: 'login')]
    public function login(SessionInterface $si): Response
    {
        if ($si->get("posts")) {
            $posts = $si->get("posts");
            $userName = $si->get("name");
            $title = $si->get("title");
            return $this->render("addnotes/index.html.twig",[
                'post' => $posts,
                'name' => $userName,
                'title' => $title,
            ]);
        }
        return $this->render("login/index.html.twig");
    }

    /**
     * Checks if the user's email address and password are correct.
     * 
     *   @param object $rq
     *     object of request class.
     *   @param object $si
     *      object of SessionInterface class.
     * 
     *   @return response
     *     if the email address and password are correct then returns to the main page else returns to the login page.
     */
    #[Route('/userlogin', name: 'userlogin')]
    public function userlogin(Request $rq, SessionInterface $si): Response
    {
        if ($si->get("posts")) {
            $obj = new UserData($this->em);
            $posts = $obj->postDetails();
            $si->set("posts", $posts);
            return $this->render("shownotes/index.html.twig",[
                'post' => $si->get("posts"),
                'name' => $si->get("name")
            ]);
        }
        $mail = $rq->get("email");
        $pswd = $rq->get("pswd");
        $user = $this->userDetails->findOneBy(['Email' => $mail]);
        if ($user == NULL) {
            return $this->render("login/index.html.twig",[
                "message" => "Email doesn't exist"
            ]);
        }
        else {
            $pass = $user->getPassword();
            if ($pass != $pswd) {
                return $this->render("login/index.html.twig",[
                    "message" => "Incorrect Password"
                ]);
            }
        }
        $si->set("email", $mail);
        $this->em->persist($user);
        $this->em->flush();
        $name = $user->getName();
        $userName = $user->getUserName();
        $obj = new UserData($this->em);
        $posts = $obj->postDetails();

        $si->set("posts", $posts);
        $si->set("name", $name);
        $si->set("userName", $userName);
        return $this->render("shownotes/index.html.twig",[
            'post' => $posts,
            'name' => $name,
        ]);
    }

    /**
     * Shows the resetpassword page.
     * 
     *   @return Response
     *     returns to the forget password page the sends the link to reset password.
     */
    #[Route('/forget', name: 'forget')]
    public function forget(): Response
    {
        return $this->render("forget/index.html.twig");
    }

    /**
     * Sends link through mail by using that the user can change their password.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return Response 
     *     if the link is successfully sent the returns to the reset password page else returns to the forget password 
     *     page to send the link again. 
     */
    #[Route('/setpassword', name: 'setpassword')]
    public function setpassword(Request $rq): Response
    {
    
        $mail = $rq->get("email");
        $host = $rq->getHost();
        $link = $host . "/resetpassword/" . $mail;
        $obj = new Otp($this->mailUserName, $this->mailPassword);
        $msg = $obj->sendMail($mail, 0, $link);
        if ($msg) {
            return $this->render("resetpassword/index.html.twig");
        }
        return $this->render("forget/index.html.twig", [
            "message" => $msg
        ]);
    }

    /**
     * Checks whether the password and confirm password is same or not.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return Response
     *     returns to the reset password page.
     */
    #[Route('/resetpassword', name: 'resetpassword')]
    public function resetpassword(Request $rq): Response
    {
        $mail = $rq->get("email");
        return $this->render("resetpassword/index.html.twig",[
            "mail" => $mail
        ]);
    }
    
    /**
     * Checks whether the password and confirm password is same or not.
     *   
     *   @param object $rq
     *     object of request class.
     * 
     *   @return Response
     *     returns to the reset password page.
     */
    #[Route('/changepassword', name: 'changepassword')]
    public function changepassword(Request $rq): Response
    {
        $mail = $rq->get("mail");
        $pswd = $rq->get("pswd");
        $cpswd = $rq->get("repswd");
        $msg = FALSE;
        $msg = User::validatepassword($pswd);
        if ($pswd != $cpswd || $msg == TRUE) {
            return $this->render("resetpassword/index.html.twig",[
                "message" => "Incorrect Password or Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character."
            ]);
        }
        $pass = $this->userDetails->findOneBy(['Email' => $mail]);
        $pass->setPassword($pswd);
        $this->em->persist($pass);
        $this->em->flush();
        return $this->render("resetpassword/index.html.twig",[
            "mail" => $mail
        ]);
    }

    /**
     * The user can add posts in their account.
     * Storing the post in Post table.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return Response
     *     returns an array of posts with their username.
     */
    #[Route('/addPost', name: 'addPost')]
    public function addPostAction(Request $rq): Response
    {
        $post = $rq->get("post");
        $userName = $rq->get("username");
        $title = $rq->get("title");
        $pt = new Post();
        $pt->setPost($post);
        $pt->setUsername($userName);
        $pt->setTitle($title);
        $this->em->persist($pt);
        $this->em->flush();
        $posts = $this->post->findBy(['Username' => $userName]);
        $data = [
            'posts' => $post,
            'title' => $title,
            'username' => $userName
        ];
        return new Response($post);
    }

    /**
     * Delete a post.
     * 
     *   @param object $rq
     *     object of request class.
     *   
     *   @return Response
     *     message whether the post was deleted.
     */
    #[Route('/delete', name: 'delete')]
    public function delete(Request $rq): Response
    {
        $id = $rq->get("id");
        $posts = $this->post->findOneBy(['id' => $id]);
        $this->em->remove($posts);
        $this->em->flush();
        return new Response("Post deleted");
    }

    /**
     * Edit a post only in their own profile and store them in the database.
     * 
     *   @param object $rq
     *     object of request class.
     * 
     *   @return Response
     *     message whether post was edited.
     */
    #[Route('/notesEdit', name: 'notesEdit')]
    public function notesEdit(Request $rq): Response
    {
        $id = $rq->get("id");
        $notes = $rq->get("notes");
        $userName = $rq->get("username");
        $notes = $this->post->findOneBy(['id' => $id]);
        $notes->setPost($notes);
        $this->em->persist($notes);
        $this->em->flush();
        return new Response("Notes Edited");
    }

    /**
     * Logout the user from their profile.
     * 
     *   @param object $rq
     *     object of request class.
     *   @param object $si
     *     object of SessionInterface class.
     *   
     *   @return Response
     *     message whether the user is logged out.
     */
    #[Route('/logout', name: 'logout')]
    public function logout(Request $rq, SessionInterface $si): Response
    {
        $userName = $rq->get("username");
        $user = $this->userDetails->findOneBy(['Name' => $userName]);
        $this->em->persist($user);
        $this->em->flush();
        $si->clear();
        return new Response("Logged out");
    }

    /**
     * Return to the page to edit the notes created by the user.
     * 
     *   @return Response
     *     returns to the page to edit notes.
     */
    #[Route('/editnotes', name: 'editnotes')]
    public function editnotes(): Response
    {
        return $this->render("editnotes/index.html.twig");
    }

    /**
     * Returns to the page where the user can create a new note.
     * 
     *   @return Response
     *     returns to the page where a new note can be created.
     */
    #[Route('/addnotes', name: 'addnotes')]
    public function addnotes(): Response
    {
        return $this->render("addnotes/index.html.twig");
    }

    /**
     * Gets the username, name and email of the current user from session and sends them for editing profile.
     * 
     *   @param object $si 
     *     object of SessionInterface class.
     * 
     *   @return Response
     *     returns to the edit profile page with the username, name and email.
     */
    #[Route('/editprofile', name: 'editprofile')]
    public function editprofile(SessionInterface $si): Response
    {
        $mail = $si->get("email");
        $name = $si->get("name");
        $userName = $si->get("userName");
        return $this->render("editprofile/index.html.twig",[
            "mail" => $mail,
            "name" => $name,
            "userName" => $userName
        ]);
    }

    /**
     * Edits the profile and stores the data in the database after checking 
     * whether the name is valid or not and the password is same.
     * 
     *   @param object $rq
     *     object of request class.
     *   @param object $si
     *     object of SessionInterface class.
     * 
     *   @return Response
     *     after editing the profile returns to the login page.
     */
    #[Route('/profile', name: 'profile')]
    public function profile(Request $rq, SessionInterface $si): Response
    {
        $fn = $rq->get("name");
        $un = $rq->get("username");
        $pswd = $rq->get("pswd");
        $mail = $si->get("email");
        $user = $this->userDetails->findOneBy(['Email' => $mail]);
        $password = $user->getPassword();
        if (!(is_numeric($fn)) || (preg_match("~[0-9]+~", $fn)) && $password == $pswd) {
            $user->setName($fn);
            $user->setUserName($un);
            $this->em->persist($user);
            $this->em->flush();
        }   
        return $this->render("login/index.html.twig");
    }

    /**
     * Shows the list of notes by a user.
     * 
     *   @return Response
     *     returns to the page which shows the notes by a user.
     */
    #[Route('/shownotes', name: 'shownotes')]
    public function shownotes(): Response
    {
        return $this->render("shownotes/index.html.twig");
    }
}
