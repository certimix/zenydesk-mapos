<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Permission Class
 *
 * Biblioteca para controle de permissões
 *
 * @author      Ramon Silva
 * @copyright   Copyright (c) 2013, Ramon Silva.
 *
 * @since       Version 1.0
 * v... Visualizar
 * e... Editar
 * d... Deletar ou Desabilitar
 * c... Cadastrar
 */
class Permission
{
    private $permissionsCache = [];

    private $table = 'permissoes'; //Nome tabela onde ficam armazenadas as permissões

    private $pk = 'idPermissao'; // Nome da chave primaria da tabela

    private $select = 'permissoes'; // Campo onde fica o array de permissoes.

    public function __construct()
    {
        log_message('debug', 'Permission Class Initialized');
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    public function checkPermission($idPermissao = null, $atividade = null)
    {
        if ($idPermissao == null || $atividade == null) {
            return false;
        }

        $idsToCheck = [];
        if (is_array($idPermissao)) {
            $idsToCheck = $idPermissao;
        } else {
            $idsToCheck[] = $idPermissao;
        }

        // Se o usuário possuir permissão secundária na sessão, adiciona para checagem combinada de autonomia
        if (isset($this->CI->session) && $this->CI->session->userdata('permissao_secundaria')) {
            $secId = $this->CI->session->userdata('permissao_secundaria');
            if ($secId && !in_array($secId, $idsToCheck)) {
                $idsToCheck[] = $secId;
            }
        }

        foreach ($idsToCheck as $id) {
            if ($this->hasPermissionForId($id, $atividade)) {
                return true;
            }
        }

        return false;
    }

    private function hasPermissionForId($id = null, $atividade = null)
    {
        if ($id == null || $atividade == null) {
            return false;
        }

        if (!isset($this->permissionsCache[$id])) {
            $this->CI->db->select($this->table . '.' . $this->select);
            $this->CI->db->where($this->pk, $id);
            $this->CI->db->limit(1);
            $array = $this->CI->db->get($this->table)->row_array();

            if ($array && !empty($array[$this->select])) {
                $raw = $array[$this->select];
                $this->permissionsCache[$id] = json_decode_legacy($raw);
            } else {
                $this->permissionsCache[$id] = [];
            }
        }

        $perms = $this->permissionsCache[$id];
        if (is_array($perms) && array_key_exists($atividade, $perms)) {
            if ($perms[$atividade] == 1) {
                return true;
            }
        }

        return false;
    }
}
