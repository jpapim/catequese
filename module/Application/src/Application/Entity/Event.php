<?php

namespace Application\Entity;

use Estrutura\ApiInteractor\AbstractApiEvent;

class Event extends AbstractApiEvent{
    protected $Titulo;
    protected $Descricao;
    protected $Urgencia;
    protected $Progresso;
    protected $Relevancia;
    protected $Severidade;
    protected $Latitude;
    protected $Longitude;
    protected $DescricaoGeolocalizaca;
    protected $Code;

    /**
     * @param mixed $Code
     */
    public function setCode($Code)
    {
        $this->Code = $Code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param mixed $DescricaoGeolocalizaca
     */
    public function setDescricaoGeolocalizaca($DescricaoGeolocalizaca)
    {
        $this->DescricaoGeolocalizaca = $DescricaoGeolocalizaca;
    }

    /**
     * @return mixed
     */
    public function getDescricaoGeolocalizaca()
    {
        return $this->DescricaoGeolocalizaca;
    }

    /**
     * @param mixed $Descricao
     */
    public function setDescricao($Descricao)
    {
        $this->Descricao = $Descricao;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->Descricao;
    }

    /**
     * @param mixed $Latitude
     */
    public function setLatitude($Latitude)
    {
        $this->Latitude = $Latitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->Latitude;
    }

    /**
     * @param mixed $Longitude
     */
    public function setLongitude($Longitude)
    {
        $this->Longitude = $Longitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->Longitude;
    }

    /**
     * @param mixed $Progresso
     */
    public function setProgresso($Progresso)
    {
        $this->Progresso = $Progresso;
    }

    /**
     * @return mixed
     */
    public function getProgresso()
    {
        return $this->Progresso;
    }

    /**
     * @param mixed $Relevancia
     */
    public function setRelevancia($Relevancia)
    {
        $this->Relevancia = $Relevancia;
    }

    /**
     * @return mixed
     */
    public function getRelevancia()
    {
        return $this->Relevancia;
    }

    /**
     * @param mixed $Severidade
     */
    public function setSeveridade($Severidade)
    {
        $this->Severidade = $Severidade;
    }

    /**
     * @return mixed
     */
    public function getSeveridade()
    {
        return $this->Severidade;
    }

    /**
     * @param mixed $Titulo
     */
    public function setTitulo($Titulo)
    {
        $this->Titulo = $Titulo;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->Titulo;
    }

    /**
     * @param mixed $Urgencia
     */
    public function setUrgencia($Urgencia)
    {
        $this->Urgencia = $Urgencia;
    }

    /**
     * @return mixed
     */
    public function getUrgencia()
    {
        return $this->Urgencia;
    }


} 