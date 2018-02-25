<?php

namespace App\v1\Models\Entity;
/**
 * @Entity
 * @Table(name="adm_parceiro")
 */
class Parceiro{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="par_int_codigo", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $par_int_codigo;
    /**
    * @var string
    * @Column(type="string", length=255)
    */
    protected $par_var_nome;
    /**
    * @var string
    * @Column(type="datetime")
    */
    protected $par_dti_data;
    /**
    * @ManyToOne(targetEntity="usuario")
    * @JoinColumn(name="usu_int_codigo", referencedColumnName="usu_int_codigo")
    */
    protected $usu_int_codigo;

    public function getPar_int_codigo(){
        return $this->par_int_codigo;
    }
    
    public function setPar_int_codigo($par_int_codigo){
        $this->par_int_codigo=$par_int_codigo;
    }
    
    public function getPar_var_nome(){
        return $this->par_var_nome;
    }
    
    public function setPar_var_nome($par_var_nome){
        $this->par_var_nome=$par_var_nome;
    }
    
    public function getPar_dat_data(){
        return $this->par_dat_data;
    }
    
    public function setPar_dat_data($par_dat_data){
        $this->par_dat_data=$par_dat_data;
    }
    
}