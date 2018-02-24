<?php

namespace App\v1\Models\Entity;
/**
 * @Entity
 * @Table(name="adm_endereco")
 */
class Endereco{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="end_int_codigo", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $end_int_codigo;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    private $end_var_logradouro;
    /**
     * @var integer
     * @Column(type="integer")
     */
    private $end_int_numero;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    private $end_var_bairro;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    private $end_var_cidade;
    /**
    * @var string
    * @Column(type="string", length=2)
    */
    private $end_var_uf;
    /**
    * @var integer
     * @Column(type="integer")
    */
    private $end_var_cep;
    /**
    * @var string
    * @Column(type="text", length=255)
    */
    private $end_var_complemento;
    
    public function getEnd_int_codigo(){
        return $this->end_int_codigo;
    }
    
    public function setEnd_int_codigo($end_int_codigo){
        $this->end_int_codigo=$end_int_codigo;
    }
    
    public function getEnd_var_logradouro(){
        return $this->end_var_logradouro;
    }
    
    public function setEnd_var_logradouro($end_var_logradouro){
        $this->end_var_logradouro=$end_var_logradouro;
    }
    
    public function getEnd_int_numero(){
        return $this->end_int_numero;
    }
    
    public function setEnd_int_numero($end_int_numero){
        $this->end_int_numero=$end_int_numero;
    }
    
    public function getEnd_var_bairro(){
        return $this->end_var_bairro;
    }
    
    public function setEnd_var_bairro($end_var_bairro){
        $this->end_var_bairro=$end_var_bairro;
    }
    
    public function getEnd_var_cidade(){
        return $this->end_var_cidade;
    }
    
    public function setEnd_var_cidade($end_var_cidade){
        $this->end_var_cidade=$end_var_cidade;
    }
    
    public function getEnd_var_uf(){
        return $this->end_var_uf;
    }
    
    public function setEnd_var_uf($end_var_uf){
        $this->end_var_uf=$end_var_uf;
    }
    
    public function getEnd_var_cep(){
        return $this->end_var_cep;
    }
    
    public function setEnd_var_cep($end_var_cep){
        $this->end_var_cep=$end_var_cep;
    }
    
    public function getEnd_var_complemento(){
        return $this->end_var_complemento;
    }
    
    public function setEnd_var_complemento($end_var_complemento){
        $this->end_var_complemento=$end_var_complemento;
    }
    
}