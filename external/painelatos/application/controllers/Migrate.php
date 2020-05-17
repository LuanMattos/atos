<?php

class Migrate extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->executarDdl();
    }

    public function index()
    {


        $this->load->library('migration');
        if (!$this->migration->current())
        {
            show_error($this->migration->error_string());
        }
    }
    protected function executarDdl(){

        $this->db->trans_start();

        $this->db->query("create table IF NOT EXISTS da_dados_globais (
                                    codigo              serial NOT NULL,
                                    nome                varchar(300),
                                    cpf                 varchar(300),
                                    rg                  varchar(300),
                                    cnh                 varchar(300),
                                    pis                 varchar(300),
                                    nis                 varchar(300),
                                    ctps                varchar(300),
                                    email               varchar(300),
                                    celular             varchar(300),
                                    teleresidencial     varchar(300),
                                    fax                 varchar(300),
                                    endereco            varchar(300),
                                    cep                 varchar(100),
                                    numero              varchar(100),
                                    bairro              varchar(300),
                                    cidade              varchar(300),
                                    estado              varchar(10),
                                    pais                varchar(100),
                                    certidao_nasc       varchar(300),
                                    agencia             varchar(300),
                                    conta               varchar(300),
                                    banco               varchar(300),
                                    nomepai             varchar(300),
                                    nomemae             varchar(300),
                                    primary key (codigo)
                    )");
        $this->db->query("CREATE TABLE if not exists usuarios(
                                codigo       serial NOT NULL,
                                login        varchar(500),
                                senha        varchar(1000),
                                ultimoacesso timestamp,
                                created_at   timestamp default now(),
                                updated_at   timestamptz default now(),
                                primary key (codigo)
                                )");
        $this->db->query("DROP      TRIGGER if exists  trigger_set_timestamp ON usuarios");
        $this->db->query("CREATE OR REPLACE FUNCTION trigger_set_timestamp() RETURNS TRIGGER AS $$ BEGIN NEW.updated_at = NOW();
                                RETURN NEW;
                                END;
                                $$ LANGUAGE plpgsql");
        $this->db->query("DROP      TRIGGER if exists  set_timestamp ON usuarios");
        $this->db->query("CREATE TRIGGER set_timestamp
                                BEFORE UPDATE ON usuarios
                                FOR EACH ROW
                                EXECUTE PROCEDURE trigger_set_timestamp()");
        $this->db->query("ALTER TABLE usuarios ADD COLUMN if not exists  __ci_last_regenerate numeric(500)");

        $transaction = $this->db->trans_complete();
        $data_adm = $this->db->query("select codigo  from usuarios where login ilike 'adm@ibugsec'")->result();
        if(empty($data_adm)){
            $this->db->query("insert into usuarios values(default ,'adm@ibugsec','$2y$10$6S25pd0o1OxbjGBWT02BDey0q06Yugmav9mUbY.jzsm7n8VuLmMju',default,default,default,null)");
        }
        $this->db->query("ALTER TABLE da_dados_globais ADD COLUMN if not exists  orgaoemissor varchar (20)");
        $this->db->query("ALTER TABLE da_dados_globais ADD COLUMN if not exists  catcnh varchar (2)");
        $this->db->query("ALTER TABLE da_dados_globais ADD COLUMN if not exists  pasep varchar (500)");


        $this->db->query("create table IF NOT EXISTS wiki (
                                          codigo       serial NOT NULL,
                                          descricao    varchar (1000),
                                          link         varchar (600),                                          
                                          created_at   timestamp default now(),
                                          updated_at   timestamptz default now(),                                          
                                          texto        varchar(100000),
                                          script       varchar (100000),                                         
                                          font         varchar (100000),
                                          primary key (codigo)

                                    )");
        $this->db->query("CREATE TABLE IF NOT EXISTS linguagem(
                                                    codigo          serial   NOT NULL,
                                                    descricao       varchar(600),
                                                    sigla           varchar(8),
                                                    primary key (codigo)
                                                    
                                        );");

        $this->db->query("ALTER TABLE wiki DROP constraint if exists linguagem_pkey;");
        $this->db->query("ALTER TABLE wiki ADD COLUMN IF NOT EXISTS codlinguagem bigint constraint linguagem_pkey references linguagem");
        $this->db->query("insert into linguagem values
                                        (default ,'PHP','PHP'),
                                        (default ,'JavaScript','JS'),
                                        (default ,'Java','J2'),
                                        (default ,'PostgreSql','PGSQL'),
                                        (default ,'MySql','MySql')
                                        ");


        if(!$transaction){
            $this->response("error",["msg"=>"Erro ao atualizar base de dados!"]);
        }
        $this->response("success",["msg"=>"Base Atualizada com sucesso!"]);

    }


}
