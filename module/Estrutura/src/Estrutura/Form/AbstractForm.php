<?php

namespace Estrutura\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterAwareInterface;

class AbstractForm extends Form implements InputFilterAwareInterface {

    /**
     *
     * @var type 
     */
    protected static $sm;

    /**
     *
     * @var type 
     */
    protected static $config;

    /**
     * @var \Zend\InputFilter\InputFilter
     */
    protected $inputFilter;

    /**
     * @var \Mvc\Form\FormObject
     */
    protected $formObject;

    /**
     * 
     * @param \Zend\InputFilter\InputFilter $inputFilter
     * @return \Zend\InputFilter\InputFilter
     */
    public function adicionaInputFilterPadrao(\Zend\InputFilter\InputFilter $inputFilter) {
        foreach ($this->getElements() as $element) {

            if ($element instanceof \Zend\Form\Element\Date) {

                $inputFilter->add(array(
                    'name' => $element->getName(),
                    'validators' => array(
                        array(
                            'name' => 'Date',
                            'options' => [
                                'format' => 'd/m/Y'
                            ]
                        ),
                    ),
                ));
            }
        }
        return $inputFilter;
    }

    /**
     * @return FormObject
     */
    public function formObject() {
        return $this->formObject;
    }

    /**
     * 
     * @param type $sm
     */
    public static function setServiceManager($sm) {
        self::$sm = $sm;
    }

    /**
     * 
     * @return type
     */
    public function sm() {
        return self::$sm;
    }

    /**
     * Busca uma parâmetro das configurações do framework
     *
     * Para busca em arrays encadeados, deve ser passado um parâmetro para cada filho, podendo passar quantos parâmetros
     * quanto necessário
     *
     * @param $param1
     * @param null $param2
     */
    public function getConfig($param1, $param2 = null) {
        if (!$config = self::$config) {
            $config = self::$config = $this->sm()->get("Config");
        }

        $parametros = func_get_args();

        foreach ($parametros as $parametro) {
            if (!array_key_exists($parametro, $config)) {
                return null;
            }
            $config = $config[$parametro];
        }

        return $config;
    }

    /**
     * 
     * @return type
     */
    public function getInputFilter() {
        return $this->inputFilter;
    }

}
