<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:51
 */

namespace PeriodoLetivo\Controller;



use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Pagination;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;


class PeriodoLetivoController extends AbstractCrudController {

    /**
     * @var \PeriodoLetivo\Service\PeriodoLetivoService
     */
    protected  $service;
    /**
     * @var \PeriodoLetivo\Form\PeriodoLetivoForm
     */
    protected $form;

    public function  __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service,$this->form);
    }

    public function indexPaginationAction(){

        $filter = $this->getFilterPage();

        $campos_filter = [
            '0'=>[
                'filter' => "categoria_peso.nm_categoria_peso LIKE ?"
            ]
        ];

        $paginator = $this->service->getPeriodoLetivoPaginator($filter, $campos_filter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());
        $countPerPage = $this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
           current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel();
    }


} 