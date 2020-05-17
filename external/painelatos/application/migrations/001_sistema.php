<?php


class Migration_Sistema extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(
           ['codigo' =>
                ['type' =>
                    'INT',
                    'constraint' => 9,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
               'nome' => [
                        'type' => 'VARCHAR',
                        'constraint' => '200'
            ],
               'nomepai' => [
                    'type' => 'VARCHAR',
                   'constraint' => '200',
                    'null' => true
               ],
               'nomemae' => [
                   'type' => 'VARCHAR',
                   'constraint' => '200',
                   'null' => true
               ],
               'rua' => [
                   'type' => 'VARCHAR',
                   'constraint' => '500',
                   'null' => true
               ],
               'bairro' => [
                   'type' => 'VARCHAR',
                   'constraint' => '500',
                   'null' => true
               ],
               'cidade' => [
                   'type' => 'VARCHAR',
                   'constraint' => '500',
                   'null' => true
               ],
               'pais' => [
                   'type' => 'VARCHAR',
                   'constraint' => '500',
                   'null' => true
               ],
               'uf' => [
                   'type' => 'VARCHAR',
                   'constraint' => '2',
                   'null' => true
               ],
               'complemento' => [
                   'type' => 'VARCHAR',
                   'constraint' => '500',
                   'null' => true
               ],
               'apto' => [
                   'type' => 'VARCHAR',
                   'constraint' => '50',
                   'null' => true
               ],
               'bloco' => [
                   'type' => 'VARCHAR',
                   'constraint' => '50',
                   'null' => true
               ],
               'numero' => [
                   'type' => 'INT',
                   'constraint' => 9,
                   'null' => true
               ],
               'cpf' => [
                   'type' => 'VARCHAR',
                   'constraint' => "25",
                   'null' => true
               ],
               'telefone' => [
                   'type' => 'VARCHAR',
                   'constraint' => "25",
                   'null' => true
               ],
               'email' => [
                   'type' => 'VARCHAR',
                   'constraint' => "250",
                   'null' => true
               ],
               'tel_res' => [
                   'type' => 'VARCHAR',
                   'constraint' => "250",
                   'null' => true
               ],
               'telefone2' => [
                   'type' => 'VARCHAR',
                   'constraint' => "250",
                   'null' => true
               ],
               'cnh' => [
                   'type' => 'VARCHAR',
                   'constraint' => "250",
                   'null' => true
               ],
               'certnasc' => [
                   'type' => 'VARCHAR',
                   'constraint' => "250",
                   'null' => true
               ]

        ]
        );
        $this->dbforge->add_key('codigo', TRUE);
        $this->dbforge->create_table('da_dados_globais');
    }

    public function down()
    {
        $this->dbforge->drop_table('da_dados_globais');
    }
}