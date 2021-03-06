<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\Form\Element;

use Zend\Form\Element;

class CheckboxCharacter extends Checkbox
{
    /**
     * @author: Alysson Vicuna - Componente criado para permitir que um Checkbox trabalhe como S ou N
     */
    /**
     * @var string
     */
    protected $uncheckedValue = 'N';

    /**
     * @var string
     */
    protected $checkedValue = 'S';

}
