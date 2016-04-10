<?php

namespace Application\Service;

use Estrutura\Service\AbstractEstruturaService;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class ApplicationService extends AbstractEstruturaService {

    public function getSmtpTranport($contaEmail) {

        $transport = new SmtpTransport();
        $transport->setOptions(
                new SmtpOptions($this->getServiceLocator()->get('Config')['smtp_options'][$contaEmail])
        );
        return $transport;
    }

    public function tratarModelo($array, $modelo) {
        $modeloArray = [];
        foreach ($array as $name => $item) {
            $modeloArray[] = '{{' . $name . '}}';
        }

        $tratado = str_replace($modeloArray, array_values($array), $modelo);
        return $tratado;
    }

    public function getModelo($modelo) {
        $file = __DIR__ . '/../Modelo/' . $modelo . '.modelo';
        return file_get_contents($file);
    }

}
