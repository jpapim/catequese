<?php
namespace Estrutura\View\Helper;
use Zend\View\Helper\AbstractHelper;

class Versionamento extends AbstractHelper
{

    /**
     * @author: Alysson Vicuña de Oliveira
     * Retorna a versão do projeto, seja branch ou tag
     */
    public function getGitFullVersion() {
        exec("git describe --tags --abbrev=0", $tagNumber);
        exec("git rev-parse --abbrev-ref HEAD", $branchName);
        return "Branch|Tag: " . array_pop($branchName) . " - Revisão: " . array_pop($tagNumber);
    }

    /**
     * @author: Alysson Vicuña de Oliveira
     * Retorna a versão do projeto, seja branch ou tag
     */
    private function getSvnFullVersion() {
        exec("svn info | grep \"Revision\" | awk '{print $2}'", $revisionNumber);
        exec("svn info | grep '^URL:' | egrep -o '(tags|branches)/[^/]+|trunk' | egrep -o '[^/]+$'", $branchName);

        return "Branch|Tag: " . array_pop($branchName) . " Revisão: " . array_pop($revisionNumber);
    }
}
