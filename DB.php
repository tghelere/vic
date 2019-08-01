<?
class DB
{
    protected $_db;
    public $_tabela;
    public function __construct()
    {
        $this->_db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PWD, [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
    }

    public function insert(array $dados)
    {
        $campos = "`" . implode("`, `", array_keys($dados)) . "`";
        $valores = "'" . implode("','", array_values($dados)) . "'";
        $this->_db->query(" INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores}) ");
        $id = $this->_db->lastInsertId();
        return $id;
    }

    public function read($where = null, $limit = null, $offset = null, $orderby = null)
    {
        $where = ($where != null ? "WHERE {$where}" : "");
        $limit = ($limit != null ? "LIMIT {$limit}" : "");
        $offset = ($offset != null ? "OFFSET {$offset}" : "");
        $orderby = ($orderby != null ? "ORDER BY {$orderby}" : "");
        $q = $this->_db->query(" SELECT * FROM `{$this->_tabela}` {$where} {$orderby} {$limit} {$offset} ");
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchAll();
    }

    public function update(array $dados, $where)
    {
        foreach ($dados as $key => $value) {
            $campos[] = "{$key} = '{$value}'";
        }
        $campos = implode(", ", $campos);
        return $this->_db->query(" UPDATE `{$this->_tabela}` SET {$campos} WHERE {$where} ");
    }

    public function delete($where)
    {
        return $this->_db->query(" DELETE FROM `{$this->_tabela}` WHERE {$where} ");
    }
}
