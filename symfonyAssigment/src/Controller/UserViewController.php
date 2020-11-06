<?php

namespace App\Controller;
use App\Entity\Books;
use App\Entity\OrderBook;
use App\Entity\User;

use App\Form\SignUpFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserViewController extends AbstractController
{


    public function updateProfile(Request $request,EntityManagerInterface $em,UserPasswordEncoderInterface $encoder)
    {
        $loginUser=($this->getUser());
//        $email=($loginUser->getUsername());
//        $password=($loginUser->getPassword());

//        $user->setEmail($email);
//        $user->setPassword($password);
        $form=$this->createForm(SignUpFormType::class,$loginUser);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()) {
            $user=$form->getData();
            $user->setPassword($encoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            $em->persist($loginUser);
            $em->flush();
            $this->addFlash('success','Update Successfully');
            return $this->redirectToRoute('userView');

        }

        return $this->render('user_view/updateProfile.html.twig',[
            'updateProfile' => $form->createView()
        ]);


    }

    public function userView(Request $request,EntityManagerInterface $em):Response
    {
        $user=$this->getUser();
        //dd($user);
        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl("bookSearch"))
            ->add('Search_Books',TextType::class,['attr' => ['placeholder' => 'Search by name or author']])
            ->add('submit',SubmitType::class)
            ->getForm()
        ;

        return $this->render('user_view/userView.html.twig',[
           'Form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/bookSearch",name="bookSearch")
     * @param Request $request
     */

    public function handleSearch(Request $request)
    {

        $form=$this->createFormBuilder()
            ->setAction($this->generateUrl("bookSearch"))
            ->add('Search_Books',TextType::class)
            ->add('submit',SubmitType::class)
            ->getForm()
        ;
        $searchKey = ($request->request->get('form')['Search_Books']);
        $books = $this->getDoctrine()
            ->getRepository(Books::class)
            ->getBooks($searchKey)
        ;
        //dd($books);

        return $this->render('user_view/searchView.html.twig',[
            'Form'=>$form->createView(),
            'books'=>$books

        ]);



    }
    public function viewDetails($id)
    {
        $bookDetail = $this->getDoctrine()
            ->getRepository(Books::class)
            ->find($id);
        //$publishedDate=($bookDetail->getPublishedDate()->format('Y-m-d H:i:s'));

        return $this->render('user_view/bookDetails.html.twig',[
            'bookDetails'=>$bookDetail,
        ]);
    }

    public function orderBook($id,EntityManagerInterface $entityManager,Request $request,\Swift_Mailer $mailer,SessionInterface $session):Response
    {
        $form=$this->createFormBuilder()

            ->add('Phone_Number',TextType::class)
            ->add('Address',TextareaType::class)
            ->add('Order',SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $orderDetails=($form->getData());
            $phone_Number=($orderDetails['Phone_Number']);
            $address=($orderDetails['Address']);

            $user=($this->getUser());
            $userEmail=($user->getEmail());

            $book = $this->getDoctrine()
                ->getRepository(Books::class)
                ->find($id);

            $orderBook = new OrderBook();
            $orderBook->setUserEmail($user);
            $orderBook->setBookId($book);
            $orderBook->setProcessing(false);
            $orderBook->setPhoneNumber($phone_Number);
            $orderBook->setAddress($address);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($orderBook);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();


            $message = (new \Swift_Message('Order Confirmation Email'))
                ->setFrom('dawoodnaveed234@gmail.com')
                ->setTo('dawoodnaveed@gmail.com')
                ->setTo($userEmail)
                ->setBody(
                   $this->renderView('user_view/emailBody.html.twig',
                       ['bookDetails'=>$book]
                   ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success','Your order Received and Kindly check the confirmation mail on your registered email');

            return $this->redirectToRoute('userView');

        }

            return $this->render('user_view/orderView.html.twig',[
                'Form'=>$form->createView(),
            ]);
    }

    public function processedOrders(SessionInterface $session)
    {
        $userId=($this->getUser()->getId());
        //$userId=($session->get('loginUser'));
        $processedOrders = $this->getDoctrine()
            ->getRepository(OrderBook::class)
            ->findProcessedOrders($userId);
        if(!$processedOrders) {
            $this->addFlash('success','There are no order in Processed');
            return $this->render('user_view/orderStatus.html.twig',[
                'order'=>NULL
            ]);
        }


        //($processedOrders);
        return $this->render('user_view/orderStatus.html.twig',[
            'order'=>$processedOrders,
        ]);
    }

    public function unProcessedOrders(SessionInterface $session)
    {
        $userId=($this->getUser()->getId());
        //$userId=($session->get('loginUser'));

        $unProcessedOrders = $this->getDoctrine()
            ->getRepository(OrderBook::class)
            ->findunProcessedOrders($userId);

        if(!$unProcessedOrders) {
            $this->addFlash('success','There are no order in Processed');
            return $this->render('user_view/orderStatus.html.twig',[
                'order'=>NULL
            ]);
        }

        return $this->render('user_view/orderStatus.html.twig',[
            'order'=>$unProcessedOrders,
        ]);

    }
    public function ajaxAction(Request $request)
    {

        $startingValue = ($request->request->get('limit'));
        $startingValue=($startingValue-1)*10;
        $endingValue=10;
        $bookDetail = $this->getDoctrine()
            ->getRepository(Books::class)
            ->findBook($startingValue,$endingValue);

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array('data' => $bookDetail));
        }

        return new Response('This is not ajax!', 400);
    }

}
