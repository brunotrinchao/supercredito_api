<?php

namespace App\v1\Models\Entity;
/**
 * @Entity
 * @Table(name="adm_contato")
 */
class Contato{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="con_int_codigo", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $con_int_codigo;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    private $con_var_telefone;
    /**
    * @var string
    * @Column(type="datetime")
    */
    private $con_dti_inclusao;
    
    public function getCon_int_codigo(){
        return $this->con_int_codigo;
    }
    
    public function setCon_int_codigo($con_int_codigo){
        $this->con_int_codigo=$con_int_codigo;
    }
    
    public function getCon_var_telefone(){
        return $this->con_var_telefone;
    }
    
    public function setCon_var_telefone($con_var_telefone){
        $this->con_var_telefone=$con_var_telefone;
    }
    
    public function getCon_dti_inclusao(){
        return $this->con_dti_inclusao;
    }
    
    public function setCon_dti_inclusao($con_dti_inclusao){
        $this->con_dti_inclusao=$con_dti_inclusao;
    }
    
}