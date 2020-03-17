<?php


class Database_model extends CI_Model
{

    public static $TABLE_NAME = "columns";
    public static $TABLES_TABLE_NAME = "tables";
    public static $TYPES_TABLE_NAME = "column_types";


    function __construct()
    {
        parent::__construct();
        self::$TABLE_NAME = $this->config->item('table_prefix') . self::$TABLE_NAME;
        self::$TABLES_TABLE_NAME = $this->config->item('table_prefix') . self::$TABLES_TABLE_NAME;
        self::$TYPES_TABLE_NAME = $this->config->item('table_prefix') . self::$TYPES_TABLE_NAME;
    }


    function get_table($table_name)
    {
        if (!$this->db->table_exists($table_name)) {


            throw new Exception("table_not_found");
        }

        $data = $this->db->get($table_name)->result_array();
        return $data;
    }

    function get_table_id_by_table_name($table_name)
    {
        return $this->db->get_where(self::$TABLES_TABLE_NAME, array("table_name" => $table_name))->result_array();
    }

    function upload_row($table_name, $data)
    {
        if (!$this->db->table_exists($table_name)) {


            throw new Exception("table_not_found");
        }

        return $this->db->insert($table_name, $data);
    }

    function add_column($column_name){
        $this->db->insert(self::$TYPES_TABLE_NAME, array("name" => nice_to_normal($column_name), "nice_name" => $column_name));
    }

    function delete_row($table_name, $data)
    {
        if (!$this->db->table_exists($table_name)) {


            throw new Exception("table_not_found");
        }

        return $this->db->delete($table_name, $data);
    }

    function get_column_types()
    {
        return $this->db->get(self::$TYPES_TABLE_NAME)->result_array();
    }

    function update_row($table_name, $condition, $data)
    {
        if (!$this->db->table_exists($table_name)) {


            throw new Exception("table_not_found");
        }

        foreach ($condition as $key => $value) {
            $this->db->where($key, $value);
        }

        return $this->db->update($table_name, $data);
    }

    function get_column($table_name, $column_name)
    {
        $this->db->select($column_name);
        return $this->db->get($table_name)->result_array();
    }

    function get_columns($table_name)
    {
        $result = $this->db->get($table_name)->result_array();
        $cols = array();
        foreach ($result[0] as $key => $value) {
            $cols[] = $key;
        }
        return $cols;
    }

    
}