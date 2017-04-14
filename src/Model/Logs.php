<?php

namespace base\Model;

use PDO;

class Logs {

    public $id;
    public $site;
    public $level;
    public $message;
    public $file;
    public $line;
    public $user;
    public $date;

    const ERROR_LEVEL = [
        1 => 'E_ERROR',
        2 => 'E_WARNING',
        4 => 'E_PARSE',
        8 => 'E_NOTICE',
        16 => 'E_CORE_ERROR',
        32 => 'E_CORE_WARNING',
        64 => 'E_COMPILE_ERROR',
        128 => 'E_COMPILE_WARNING',
        256 => 'E_USER_ERROR',
        512 => 'E_USER_WARNING',
        1024 => 'E_USER_NOTICE',
        2048 => 'E_STRICT',
        4096 => 'E_RECOVERABLE_ERROR',
        8192 => 'E_DEPRECATED',
        16384 => 'E_USER_DEPRECATED',
        32767 => 'E_ALL'
    ];

    /**
     * Logs constructor.
     * @param int $id
     * @param string $site
     * @param string $level
     * @param string $message
     * @param string $file
     * @param string $line
     * @param string $date
     */
    public function __construct(int $id = null, string $site = null, string $level = null, string $message = null,
                                string $file = null, string $line = null, string $date = null)
    {
        if ($id === NULL) {
            return;
        }
        $this->id = $id;
        $this->site = $site;
        $this->level = $level;
        $this->message = $message;
        $this->file = $file;
        $this->line = $line;
        $this->date = $date;
    }


    public static function insert($site, $level, $message, $file, $line, $date) {
        $user = NULL;
        $req = BDD::instance()->prepare('INSERT INTO '.BDTables::LOGS.'(site, level, message, date, file, line) VALUES(:site, :level, :message, :date, :file, :line)');
        $req->execute(['site' => $site, 'level' => $level, 'message' => $message, 'date' => $date, 'file' => $file, 'line' => $line]);
    }

    /**
     * Retourne un tableau des derniers logs (limite en param)
     * @param int $limit
     * @return array
     */
    public static function getLastLogs(int $limit){
        $req = BDD::instance()->prepare('SELECT l.*
                                         FROM '.BDTables::LOGS.' l 
                                         ORDER BY date DESC LIMIT :limit');
        $req->bindValue('limit', $limit, PDO::PARAM_INT);
        $req->execute();
        $return = [];

        foreach ($req->fetchAll() as $l){
            $log = new Logs($l['id'], $l['site'], $l['level'], $l['message'], $l['file'], $l['line'], $l['date']);
            $return[] = $log;
        }

        return $return;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return htmlspecialchars($this->site);
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return htmlspecialchars($this->message);
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return htmlspecialchars($this->file);
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return htmlspecialchars($this->line);
    }

    /**
     * @param string $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Retourne le type d'erreur en string (label)
     * @return string
     */
    public function getErrorLabel(){
        return htmlspecialchars(self::ERROR_LEVEL[$this->level]);
    }
}

?>