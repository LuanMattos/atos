<?php
namespace Modules\Account\RestoreAccount;

use Service\GeneralService;

class RestoreAccount extends GeneralService {

    /**
     * Gera um codigo para verificacao, verificando se o mesmo já existe
    **/
    public function gerarCodigoValidacao(){
        $code = $this->gerarCodigoVolta();
        if(!$code){
            $codigo = $this->gerarCodigoVolta();
            if(!$codigo){
                return $codigo . uniqid() . rand();
            }
            return $codigo . uniqid();
        }

        return $code;

    }
    /**
     * Auxilia a geracao de codigo voltando um valor unico
    **/
    public function gerarCodigoVolta(){
        $uniqueid       = substr(uniqid(),6,12);
        $finally        = $uniqueid;

        $this->load->model("account/home/Account_home_model");

        $exist = $this->Account_home_model->getWhere(["code_verification"=>$finally]);
        if(count($exist)){
            return false;
        }

        return $finally;
    }


}
