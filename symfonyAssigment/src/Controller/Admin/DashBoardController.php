<?php

namespace App\Controller\Admin;
use App\Entity\Books;
use App\Entity\OrderBook;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashBoardController extends AbstractDashboardController
{
    private $role;
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(BooksCrudController::class)->generateUrl());
    }
    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Important');
        yield MenuItem::linkToCrud('Books', 'fa fa-file-pdf', Books::class);
        yield MenuItem::linkToCrud('User', 'fa fa-file-word', User::class);
        yield MenuItem::linkToCrud('Orders', 'fa fa-file-word', OrderBook::class);
        //yield MenuItem::linkToCrud('UnProcessedOrder','fa fa-file-word',unProcessedCrudController::getEntityFqcn());
       // yield MenuItem::linkToCrud('ProcessedOrder','fa fa-file-word',processedOrderCrudController::getEntityFqcn());
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()

            ->setTitle('Easy Admin');
    }




    // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);

}
