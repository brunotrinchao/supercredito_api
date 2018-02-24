<?php

namespace App\v1\Models\Entity;
/**
 * @Entity
 * @Table(name="adm_usuario")
 */
class Usuario{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="usu_int_codigo", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $usu_int_codigo;
    /**
    * @var string
    * @Column(type="string", length=64)
    */
    protected $usu_var_nome;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    protected $usu_var_sobrenome;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    protected $usu_var_email;
    /**
    * @ManyToOne(targetEntity="parceiro")
    * @JoinColumn(name="par_int_codigo", referencedColumnName="par_int_codigo")
    */
    protected $par_int_codigo;
    /**
    * @ManyToOne(targetEntity="endereco")
    * @JoinColumn(name="end_int_codigo", referencedColumnName="end_int_codigo")
    */
    protected $end_int_codigo;
    /**
    * @ManyToOne(targetEntity="contato")
    * @JoinColumn(name="con_int_codigo", referencedColumnName="con_int_codigo")
    */
    protected $con_int_codigo;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    protected $usu_var_foto;


    public function getUsu_int_codigo(){
        return $this->usu_int_codigo;
    }
    
    public function setUsu_int_codigo($usu_int_codigo){
        $this->usu_int_codigo=$usu_int_codigo;
    }
    
    public function getUsu_var_nome(){
        return $this->usu_var_nome;
    }
    
    public function setUsu_var_nome($usu_var_nome){
        if (!$usu_var_nome && !is_string($usu_var_nome)) {
            throw new \InvalidArgumentException("Sobrenome é obrigatório.", 400);
        }
        $this->usu_var_nome = $usu_var_nome;
        return $this;
    }
    
    public function getUsu_var_sobrenome(){
        return $this->usu_var_sobrenome;
    }
    
    public function setUsu_var_sobrenome($usu_var_sobrenome){
        if (!$usu_var_sobrenome && !is_string($usu_var_sobrenome)) {
            throw new \InvalidArgumentException("Sobrenome é obrigatório.", 400);
        }
        $this->usu_var_sobrenome = $usu_var_sobrenome;
        return $this;
    }
    
    public function getUsu_var_email(){
        return $this->usu_var_email;
    }
    
    public function setUsu_var_email($usu_var_email){
        if (!$usu_var_email && !is_string($usu_var_email)) {
            throw new \InvalidArgumentException("E-mail é obrigatório.", 400);
        }
        $this->usu_var_email = $usu_var_email;
        return $this;
    }
    
    public function getPar_int_codigo(){
        return $this->par_int_codigo;
    }
    
    public function setPar_int_codigo($par_int_codigo){
        $this->par_int_codigo=$par_int_codigo;
    }
    
    public function getEnd_int_codigo(){
        return $this->end_int_codigo;
    }
    
    public function setEnd_int_codigo($end_int_codigo){
        $this->end_int_codigo=$end_int_codigo;
    }
    
    public function getCon_int_codigo(){
        return $this->con_int_codigo;
    }
    
    public function setCon_int_codigo($con_int_codigo){
        $this->con_int_codigo=$con_int_codigo;
    }
    
    public function getUsu_var_foto(){
        return $this->usu_var_foto;
    }
    
    public function setUsu_var_foto($usu_var_foto){
        $this->usu_var_foto=$usu_var_foto;
    }

}