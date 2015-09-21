<?php

	namespace UserBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    use Uneak\PortoAdminBundle\Blocks\Content\Content;
    use Uneak\PortoAdminBundle\Blocks\Datatable\Datatable;
    use Uneak\PortoAdminBundle\Blocks\Form\Form;
    use Uneak\PortoAdminBundle\Blocks\Layout\Entity;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContent;
    use Uneak\PortoAdminBundle\Blocks\Layout\EntityContentScroll;
    use Uneak\PortoAdminBundle\Blocks\Menu\Menu;
    use Uneak\PortoAdminBundle\Blocks\Panel\Panel;
    use Uneak\PortoAdminBundle\Blocks\Photo\Photo;
    use Uneak\PortoAdminBundle\Blocks\Progress\ProgressBar;
    use Uneak\PortoAdminBundle\Blocks\Search\Search;
    use Uneak\PortoAdminBundle\Blocks\UIElements\Tabs;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStats;
    use Uneak\PortoAdminBundle\Blocks\Widget\WidgetStatus;
    use Uneak\PortoAdminBundle\Controller\LayoutController;
    use Uneak\PortoAdminBundle\Controller\LayoutEntityController;
    use Uneak\RoutesManagerBundle\Routes\FlattenEntityRoute;
    use Uneak\RoutesManagerBundle\Routes\FlattenRoute;
    use Doctrine\ORM\Query\Expr;
    use UserBundle\Entity\User;
    use UserBundle\Form\UserType;

    class AdminUserController extends LayoutEntityController {



	}
