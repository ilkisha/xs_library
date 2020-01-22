<?php


namespace App\Http;


use App\Data\BookDTO;
use App\Data\ErrorDTO;
use App\Service\Books\BookServiceInterface;
use App\Service\UserServiceInterface;
use Core\DataBinder;
use Core\TemplateInterface;

class BookHttpHandler extends UserHttpHandlerAbstract
{
    /**
     * @var BookServiceInterface
     */
    private $bookService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * BookHttpHandler constructor.
     * @param TemplateInterface $template
     * @param DataBinder $dataBinder
     * @param BookServiceInterface $bookService
     * @param UserServiceInterface $userService
     */
    public function __construct(
        TemplateInterface $template,
        DataBinder $dataBinder,
        BookServiceInterface $bookService,
        UserServiceInterface $userService)
    {
        parent::__construct($template, $dataBinder);
        $this->bookService = $bookService;
        $this->userService = $userService;
    }

    /**
     * @param array $formData
     */
    public function add(array $formData = [])
    {

        $user = $this->userService->currentUser();

        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        if($user->getIsAdmin() == '0'){
            $this->redirect('profile.php');
            exit;
        }


        if(isset($formData['add'])){
            $this->handleAddProcess($formData);
        }else{
            $this->render('books/add');
        }
    }

    /**
     * @param array $formData
     */
    public function handleAddProcess(array $formData)
    {
        try{
            $currentUser = $this->userService->currentUser();
            /**
             * @var BookDTO $book
             */
            if($formData['name'] === '' || $formData['isbn'] === '' || $formData['description'] === ''
            || $formData['image'] === ''){
                $this->render('books/add', null, [new ErrorDTO('
                Missing data fields')]);
            }
            $book = $this->dataBinder->bind($formData, BookDTO::class);
            $book->setUser($currentUser);
            if($this->bookService->add($book)){
                $this->redirect('allBooks.php');
            }
            $this->render('books/add', null , [new ErrorDTO('This ISBN already exists!')]);
        }catch (\Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function allBooks()
    {
        $user = $this->userService->currentUser();
        $books = $this->bookService->getAll();
        $data['user'] = $user;
        $data['books'] = $books;
        $this->render('books/allBooks', $data);
    }

    public function view($getData = [])
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $book = $this->bookService->getOneById($getData['id']);
        $userId = $this->userService->currentUser()->getId();
        $isAdmin = $this->userService->currentUser()->getIsAdmin();
        $data['book'] = $book;
        $data['isAdmin'] = $isAdmin;
        $this->render('books/viewBook', $data);
    }

    public function allMyBooksCollections()
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $this->render('books/myBooksCollections', $this->getMyBooksFromDb());
    }

    public function delete(array $getData = [])
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        $this->bookService->delete((int)($getData['id']));
        $this->redirect('allBooks.php');
    }

    public function edit($formData = [], $getData = [])
    {
        if(!$this->userService->isLogged()) {
            $this->redirect('login.php');
            exit;
        }

        if($this->userService->currentUser()->getIsAdmin() === '0'){
            $this->redirect('allBooks.php');
            exit;
        }

        if(isset($formData['edit'])){
            /** @var BookDTO $book */
            $book = $this->dataBinder->bind($formData, BookDTO::class);
            $book->setId((int)$getData['id']);
            $this->bookService->edit($book, (int)$getData['id']);
            $this->redirect('allBooks.php');
        }else{
            $book = $this->bookService->getOneById($getData['id']);
            $this->render('books/editBook', $book);
        }
    }

    public function addToCollection(array $getData = [])
    {
        $bookId = (int)$getData['id'];
        $userId = (int)$this->userService->currentUser()->getId();

        if(null === $this->bookService->checkBookExistInCollection($bookId, $userId)->current()){
            $this->bookService->addToCollection($bookId, $userId);
            $this->redirect('http://localhost/xs_library/myBooksCollections.php');
            exit;
        }

        $this->redirect('http://localhost/xs_library/myBooksCollections.php');
    }

    public function removeMyBook($getData)
    {
        $bookId = (int)$getData['id'];
        $this->bookService->removeMyBook($bookId);
        $this->redirect('http://localhost/xs_library/myBooksCollections.php');
    }

    private function getMyBooksFromDb() {
        $allBooksByAuthor = $this->bookService->findAddedBooks($this->userService->currentUser()->getId());
        $books = [];

        foreach ($allBooksByAuthor as $currentBook) {
            $books[] = $this->bookService->getOneById((int)$currentBook['book_id']);
        }

        return $books;
    }
}