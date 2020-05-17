<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logado extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->output->enable_profiler(FALSE);

    }

    public function index()
    {
        $data = $this->input->post(NULL, TRUE);
        $data_s = $this->session->get_userdata();

        if(isset($data_s['logado']) && $data_s['logado']){

           redirect('Logado/logado');

        }else {

            if (!empty($data['login']) && !empty($data['senha'])) {
                $user = $this->Usuarios_model->login($data['login']);
            } else {
                $data['error_senha'] = "Usuário/senha incorreto(s)";
                $this->load->view('index', $data);
                return true;
            }

//        var_dump(password_hash("admin", PASSWORD_DEFAULT));//criptografa a sessão
            if (!empty($data) && !empty($user)) {
                foreach ($user as $line) {

                    if ($line['login'] === $data['login']) {
                        if (password_verify($data['senha'], $line['senha']) == true) {
                            $this->session->set_userdata(['usuario' => $line['login']], 1);
                            $this->session->set_userdata(['logado' => true], 1);
                            redirect('Logado/logado');
                        } else {

                            $data['error_senha'] = "Usuário/senha incorreto(s)";
                            $this->load->view('index', $data);
                        }
                    } else {

                        $data['error_senha'] = "Usuário/senha incorreto(s)";
                        $this->load->view('index', $data);
                    }
                }
            } else {

                $data['error_senha'] = "Usuário/senha incorreto(s)";
                $this->load->view('index', $data);
            }
        }

    }

    public function logado(){
        $this->load->view('logado');
    }
    public function logout()
    {
//        $this->session->unset_userdata();
        $this->session->sess_destroy();
        redirect();
    }

}
