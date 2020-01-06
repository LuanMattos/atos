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

        $this->db->query("CREATE TABLE if not exists usuarios(
                                codigo       serial NOT NULL,
                                login        varchar(500),
                                senha        varchar(1000),
                                created_at   timestamp default now(),
                                updated_at   timestamptz default now(),
                                primary key (codigo)
                                )");
        $this->db->query("CREATE OR REPLACE FUNCTION  trigger_set_timestamp() RETURNS TRIGGER AS $$ BEGIN NEW.updated_at = NOW();
                                RETURN NEW;
                                END;
                                $$ LANGUAGE plpgsql");
        $this->db->query("DROP      TRIGGER if exists  set_timestamp ON usuarios");
        $this->db->query("CREATE    TRIGGER set_timestamp
                                BEFORE UPDATE ON usuarios
                                FOR EACH ROW
                                EXECUTE PROCEDURE trigger_set_timestamp()");
        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS  __ci_last_regenerate numeric(500)");
        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS logado boolean");
        $this->db->query("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS session_coo varchar(10000)");
        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS email varchar(1000)");
        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS datanasc date");
        $this->db->query("ALTER TABLE usuarios add column IF NOT EXISTS telcel varchar(1000)");
        /** SMS **/
        $this->db->query("CREATE TABLE if not exists sms_fila (
                                                            codigo          serial not null,
                                                            msg             varchar(1000),
                                                            destinatario    numeric(13),
                                                            date_to_send    timestamp default now(),
                                                            date_send       timestamp,
                                                            response        varchar(1000),
                                                            created_at      timestamp default  now()
                            )");
        $this->db->query("CREATE TABLE if not exists provider_sms(
                                                            codigo serial not null,
                                                            conta varchar(500),
                                                            senha varchar(1000)
                                                        )");
        $this->db->query("ALTER TABLE provider_sms add column if not exists provedor varchar(500)");

        /**Paises HOME**/
        $this->db->query("DROP TABLE IF EXISTS pais CASCADE;");

        /**Account**/
        $this->db->query("create table if not exists account_home(
                                                        codigo bigserial,
                                                        code_verification varchar(1000),
                                                        code_restore      varchar(1000),
                                                        created_at   timestamp default now(),
                                                        updated_at   timestamptz default now()
                                                    )");
        $this->db->query("alter table account_home drop constraint if exists usuarios_pkey");
        $this->db->query("alter table account_home add column if not exists codusuarios bigint constraint  usuarios_pkey references usuarios");
        $this->db->query("DROP TRIGGER if exists  set_timestamp ON account_home");
        $this->db->query("CREATE    TRIGGER set_timestamp
                                        BEFORE UPDATE ON account_home
                                        FOR EACH ROW
                                        EXECUTE PROCEDURE trigger_set_timestamp()");
        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS nome       varchar(1000)");
        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS sobrenome  varchar(1000)");
        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS email_hash varchar(1000)");
        $this->db->query("ALTER TABLE account_home    ADD COLUMN IF NOT EXISTS verification_ok boolean");
        $this->db->query("ALTER TABLE usuarios        ADD COLUMN IF NOT EXISTS emailprofissional varchar(100)");

        $this->db->query("CREATE TABLE IF NOT EXISTS location_user(
                                    codigo                          serial,
                                    formatted_address_google_maps   varchar(300),
                                    latitude                        varchar(500),
                                    longitude                       varchar(500)
                        );");
        $this->db->query("ALTER TABLE location_user DROP constraint if exists usuarios_pkey;");
        $this->db->query("ALTER TABLE location_user ADD COLUMN IF NOT EXISTS codusuario bigint constraint usuarios_pkey references usuarios;");

        $transaction = $this->db->trans_complete();

        if(!$transaction){
            $this->response("error",["msg"=>"Erro ao atualizar base de dados!"]);
        }
        $this->response("success",["msg"=>"Base Atualizada com sucesso!"]);

    }


}
