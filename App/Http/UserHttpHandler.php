<?php

namespace App\Http;

use App\Data\ErrorDTO;
use App\Data\UserDTO;
use App\Http\UserHttpHandlerAbstract;
use App\Service\UserServiceInterface;

class UserHttpHandler extends UserHttpHandlerAbstract
{
    /**
     * @param UserServiceInterface $userService
     * @param array $formData
     */
    public function myProfile(UserServiceInterface $userService, array $formData){
        $currentUser = $userService->currentUser();

        if($currentUser === null) {
            $this->redirect('login.php');
        }

        if (isset($formData['edit'])) {
            $this->handleEditProcess($userService, $formData);
        } else {
            $this->render('users/myProfile', $currentUser);
        }
    }

    /**
     * @param UserServiceInterface $userService
     */
    public function index(UserServiceInterface $userService)
    {
        $this->render('home/index');
    }

    /**
     * @param UserServiceInterface $userService
     * @param $formData
     */
    public function allPendingUsers(UserServiceInterface $userService, $formData){
       if(isset($formData['approve']) && $formData['approve'] === 'Approve'){
           foreach ($formData as $id => $value){
               if($value === 'on'){
                   $user = $userService->getUserById($id);
                   $user->setActive(1);
                   $userService->approve($user);
               }
           }
       }

       $this->render('users/allPendingUsers', $userService->getAll());
    }

    /**
     * @param UserServiceInterface $userService
     * @param array $formData
     */
    public function profile(UserServiceInterface $userService,
                         array $formData = [])
    {
        if(!$userService->isLogged())
        {
            $this->redirect('login.php');
        }

        $currentUser = $userService->currentUser();
        $_SESSION['admin'] = $currentUser->getIsAdmin();
        if (isset($formData['edit'])) {
            $this->handleEditProcess($userService, $formData);
        } else {
            $this->render('users/profile', $currentUser);
        }
    }

    /**
     * @param UserServiceInterface $userService
     * @param array $formData
     */
    public function login(UserServiceInterface $userService,
                          array $formData = [])
    {
        if (isset($formData['login'])) {
            $this->handleLoginProcess($userService, $formData);
        } else {
            $this->render('users/login');
        }
    }

    /**
     * @param UserServiceInterface $userService
     * @param array $formData
     */
    public function register(UserServiceInterface $userService,
                             array $formData = [])
    {
        if (isset($formData['register'])) {
            $this->handleRegisterProcess($userService, $formData);
        } else {
            $this->render('users/register');
        }
    }

    /**
     * @param $userService
     * @param $formData
     */
    private function handleRegisterProcess($userService, $formData)
    {
        if ($formData['first_name'] == '' || $formData['last_name'] == '' || $formData['email'] == '' ||
            $formData['password'] == '' || $formData['confirm_password'] == '') {
            $this->render('users/register', null,
                [new ErrorDTO('Missing parameters!')]);
            return;
        }

        try {
            $user = $this->dataBinder->bind($formData, UserDTO::class);
            $userService->register($user, $formData['confirm_password']);
            $this->redirect("login.php");
        } catch (\Exception $e) {
            $this->render("users/register", null,
                [$e->getMessage()]);
        }
    }

    /**
     * @param $userService
     * @param $formData
     */
    private function handleLoginProcess($userService, $formData)
    {
        /** @var UserServiceInterface $userService */

        $user = $userService->login($formData['email'], $formData['password']);

        $currentUser = $this->dataBinder->bind($formData, UserDTO::class);
        $currentUser = $userService->getEmail($currentUser->getEmail());

        if ($formData['email'] == '' || $formData['password'] == '') {
            $this->render('users/login', null, [new ErrorDTO('Please enter email and password!')]);
            return;
        }

        if (null === $user) {
            $this->render("users/login", $currentUser,
                [new ErrorDTO("Email does not exist or password mismatch.")]);
            return;
        }

        if($currentUser->getActive() != '1'){
            $errorMessage = new ErrorDTO( 'Your registration is not approved by admin yet!');
            $this->render('users/login', null,
                [$errorMessage]);

        } else if (null !== $currentUser) {
            $_SESSION['id'] = $currentUser->getId();
            $_SESSION['admin'] = $currentUser->getIsAdmin();
            if($currentUser->getIsAdmin() == '0'){
                $this->redirect('allBooks.php');
                return;
            }
            $this->redirect('profile.php');
        }
    }

    /**
     * @param $userService
     * @param $formData
     */
    private function handleEditProcess($userService, $formData)
    {
        if(($formData['password'] === '' && $formData['confirm_password'] === '') ||
            ($formData['password'] === $formData['confirm_password'])){
            /** @var UserServiceInterface $userService */
            $user = $this->dataBinder->bind($formData, UserDTO::class);

            if($userService->edit($user)){
                $this->redirect('profile.php');
            }else{
                $this->render('users/myProfile', $user,
                    [new ErrorDTO('Edit failed!')]);
            }

            return;
        }

        /** @var UserServiceInterface $userService */
        $user = $userService->currentUser();
        $this->render('users/myProfile', $user,
            [new ErrorDTO('Password and Confirm password should be same,
             or one of the fields is missing!')]);

    }
}