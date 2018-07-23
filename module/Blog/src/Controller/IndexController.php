<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog\Controller
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/18
 * @license   see LICENSE
 */

namespace Blog\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Blog\Controller
 */
class IndexController extends AbstractActionController
{
    /**
     *
     * @return ViewModel
     */
    public function indexAction() : ViewModel
    {
        return new ViewModel();
    }
}
