<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 判断数据库操作是否有失败
     *
     * @param void
     *
     * @return bool true/false
     */
    public function dberror()
    {
//
//        if ($this->db->_error_number() != 0)
//        {
//            log_message('error', $this->db->_error_message());
//            return true;
//        }
//
//        return false;

        $error = $this->db->error();
        if ($error['code'] != 0) {
            log_message('error', 'DB Error:' . $error['code'] . ' - ' . $error['message']);
            return true;
        }
        return false;
    }

    /**
     * DB错误码
     *
     * @param void
     *
     * @return int MYSQL错误码
     */
    public function dberror_code()
    {
        return $this->db->_error_number();
    }

    /**
     * DB错误信息
     *
     * @param void
     *
     * @return string 错误描述
     */
    public function dberror_message()
    {
        return $this->db->_error_message();
    }

    /**
     * 获取表中的记录数
     *
     * @param string $table 表名称
     * @param array $cond 查询条件
     *
     * @return int 成功返回条数，失败返回false
     */
    public function num_rows($table, $cond = Null)
    {
        $this->db->select('count(1) as cnt');
        if (!empty($cond)) {
            $this->db->where($cond);
        }
        $query = $this->db->get($table);

        if (!$query) {
            return 0;
        }

        $row = $query->row_array();
        if (isset($row['cnt'])) {
            return $row['cnt'];
        }

        return 0;
    }

    /**
     * 获取nextval
     *
     * @param string $table 表名称(作为分类使用)
     * @param string $field 字段名称(作为二级分类使用)
     * @param int $cnt 获取数量
     *
     * @return float nextval
     */
    public function nextval($table, $field, $cnt = 1)
    {
        if (function_exists('get_nextval')) {
            return get_nextval($table . '-' . $field);
        } else {
            if (!trim($table) || !trim($field) || $cnt <= 0) {
                $this->error->set_error(ERR::ERR_INVALID_INPUT);
                return 0;
            }

            $sql = "call get_next_id('" . $table . "', '" . $field . "', " . $cnt . ", @next_id)";
            $this->db->query($sql);
            $query = $this->db->query('select @next_id as next_id');
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                if (isset($row['next_id']))
                    return $row['next_id'];
            }
        }

        return 0;
    }
}
