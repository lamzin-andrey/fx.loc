<?php
require_once APP_ROOT . '/classes/SearchTree.php';
class CAbstractDbTree{
	/*
	 * @var Где искать значения переменных 'POST' || 'GET' || 'REQUEST'
	*/
	public $_request = 'POST';
	/*
	 * @var таблица БД
	*/
	protected $_table;
	/*
	 * @var "неожиданные" ассоциации полей запроса и полей таблицы БД
	 * ключ значения массива - имя поля в таблице,  значение - ключ в request
	*/
	protected $_assoc = array();
	/*
	 * @var "неожиданные" ассоциации полей запроса и полей таблицы БД
	 * ключ значения массива - ключ в request,  значение - имя поля в таблице
	*/
	protected $_assoc_mirror = array();
	/*
	 * @var имена полей таблицы БД которые надо вставить
	*/
	protected $_insert = array();
	/*
	 * @var имена полей таблицы БД которые надо обновить
	*/
	protected $_update = array();
	/*
	 * @var имена полей в которые надо записать текущее время
	*/
	protected $_timestamps = array();
	/*
	 * @var Данные о полях требующих заполнения
	*/
	protected $_required = array();
	/*
	 * @var Объект приложения
	*/
	protected $_app;
	/*
	 * @var Идентификатор авторизованого пользователя @see setUpdateOwnerCondition
	*/
	protected $_auth_user_id;
	/*
	 * @var Поле в таблице, хранящее номер пользователя, создавшего комментарий
	*/
	protected $_field_owner_id;
	/*
	 * @var Поле - первичный ключ в таблице
	*/
	protected $_id_field_name = 'id';
	/*
	 * @var Типы полей таблицы
	*/
	protected $_field_types = array();
	
	public function __construct($app) {
		$this->_app = $app;
	}
	/**
	 * @desc Записывает данные, в поля таблицы перечисленные в insert / update
	 * Значения берутся из _request, если там их нет, то из аргумента
	 * @param $data массив ключ - имя поля таблицы, знаяение - требующее записи значение
	*/
	public function writeData($data) {
		$app = $this->_app;
		$lang = $app->lang;
		$this->validate();
		$id_field_name = isset($this->_assoc[$this->_id_field_name]) ? $this->_assoc[$this->_id_field_name] : $this->_id_field_name;
		$now = false;
		if ($id = intval($this->req($id_field_name)) ) {
			if ($id) {
				//update
				$sql_body = 'UPDATE ' . $this->_table . ' SET {DATA} WHERE ' . $id_field_name . ' = ' . $id ;
				if ($this->_field_owner_id) {
					$sql_body .= ' AND `' . $this->_field_owner_id . '` = ' . "'{$this->_auth_user_id}'";
				}
				$data = array();
				$c = 0;
				foreach ($this->_update as $field) {
					$table_field = $field;
					$field = isset($this->_assoc[$field]) ? $this->_assoc[$field] : $field;
					if (!isset($this->_timestamps[$table_field])) {
						$value = $this->req($field);
						if (!$value && isset($data[$table_field])) {
							$value = $data[$table_field];
						}
					} else {
						if (!$now) {
							$now = now();
						}
						$value = $now;
					}
					$data[] = "`{$table_field}` = '{$value}'";
					$c++;
				}
				if ($c) {
					$sql_query = str_replace('{DATA}', join(', ', $data), $sql_body);
					query($sql_query);
				}
			} else {
				json_error('msg', $lang['default_error'] . ', tmp ERROR UPDATE ID NOT FOUND');
			}
		} else {
			//insert
			$sql_body = 'INSERT INTO ' . $this->_table . ' ({FIELDS}) VALUES({VALUES})';
			$a_fields = array();
			$a_values = array();
			$c = 0;
			foreach ($this->_insert as $field) {
				$table_field = $field;
				$field = isset($this->_assoc[$field]) ? $this->_assoc[$field] : $field;
				//$value = $this->req($field);
				if (!isset($this->_timestamps[$table_field])) {
					$value = $this->req($field);
					if (!$value && isset($data[$table_field])) {
						$value = $data[$table_field];
					}
				} else {
					if (!$now) {
						$now = now();
					}
					$value = $now;
				}
				if ($value) {
					$a_fields[] = "`{$table_field}`";
					$a_values[] = "'{$value}'";
					$c++;
				}
			}
			if ($c) {
				$sql_query = str_replace('{FIELDS}', join(', ', $a_fields), $sql_body);
				$sql_query = str_replace('{VALUES}', join(', ', $a_values), $sql_query);
				query($sql_query);
			}
		}
	}
	/**
	 * @desc Получить значение из request
	 * @param $name - имя переменной в request
	*/
	protected function req($name) {
		$field_name = isset($this->_assoc_mirror[$name]) ? $this->_assoc_mirror[$name] : $name;
		$type = (isset($this->_field_types[$field_name]) ? $this->_field_types[$field_name] : 'string');
        $v = req($name, $this->_request);
		switch ($type) {
			case 'int':
				return intval($v);
			case 'float';
			case 'double';
				return floatval($v);
		}
		$s = str_replace("'", '&quot;', trim(req($name, $this->_request)) );
		$s = strip_tags($s, '<b><i><u><s><a><ul><li>');
		$s = preg_replace("#union#i", 'un<i></i>ion', $s);
		return $s;
	}
	/**
	 * @desc Валидация обязательных полей
	 * Метод обычно перегружается в наследнике для проведения остальных валидаций
	*/
	protected function validate() {
		foreach ($this->_required as $field => $msg) {
			$v = $this->req($field);
			if (!$v) {
				if ($msg) {
					json_error('msg', $msg);
				} else {
					json_error('msg', $this->_app->lang['field_is_required']);
				}
			}
		}
	}
	/**
	 * @desc   Устанавливает условие проверки, принадлежит ли редактируемая запись пользователю, который хочет ее редактировать
	 * @param  $auth_user_uid   - Идентификатор авторизованного пользователя 
	 * @param  $field_owner_id  - Имя поля, хранящего идентификатор владельца записи
	*/
	protected function setUpdateOwnerCondition($auth_user_uid, $field_owner_id) {
		$this->_auth_user_id = $auth_user_uid;
		$this->_field_owner_id = $field_owner_id;
	}
	/**
	 * @desc   Устанавливает поле, обязатедльное для заполнения
	 * @param  $field   - Имя поля
	 * @param  $message - Сообщение об ошибке
	*/
	protected function required($field, $message = null) {
		$this->_required[$field] = $message;
	}
	/**
	 * @desc Устанавливает имена полей, в которые должен быть записано текущее время
	 * @param ПРостой массив с именами полей
	*/
	protected function timestamps($fields) {
		foreach ($fields as $item) {
			$this->_timestamps[$item] = 1;
		}
	}
	/**
	 * @desc Устанавливает имена полей, которые должены быть вставлены
	 * @param Простой массив с именами полей
	*/
	protected function insert($fields) {
		$this->_insert = $fields;
	}
	/**
	 * @desc Устанавливает имена полей, которые должены быть обновлены
	 * @param Простой массив с именами полей
	*/
	protected function update($fields) {
		$this->_update = $fields;
	}
	/**
	 * @desc устанавливает "неожиданные" ассоциации полей запроса и полей таблицы БД
	 * ключ значения массива - имя поля в таблице,  значение - ключ в request
	*/
	protected function assoc($data) {
		foreach ($data as $key => $item) {
			$this->_assoc[$key] = $item;
			$this->_assoc_mirror[$item] = $key;
		}
	}
	/**
	 * @desc  Устанавливает имя таблицы, также инициализует массив _field_types типами полей
	 * @param имя таблицы
	*/
	protected function table($name) {
		$this->_table = $name;
		//TODO add cache
		$cache_key = APP_ROOT . '/files/cache/' . md5($name);
		if (file_exists($cache_key) && (strtotime(now()) -  filemtime($cache_key) <= APP_CACHE_LIFE) ) {
			$this->_field_types = json_decode( file_get_contents($cache_key) );
		}
		
		$sql_query = "SELECT * FROM {$name} LIMIT 1;";
		$res = mysql_query($sql_query);
		if ($res) {
			while ($row = mysql_fetch_array($res)) {
				$fields = array_keys($row);
				for ($i = 0; $i < count($fields); $i += 2) {
					$field_name = $fields[$i + 1];
					$field_num  = $fields[$i];
					$this->_field_types[$field_name] = mysql_field_type($res, $field_num);
				}
				break;
			}
		}
		file_put_contents($cache_key, json_encode($this->_field_types));
	}
	/**
	 * @desc строит дерево (структуру данных) с неограниченным уровнем вложенности,
	 * @param string $condition - фрагмент sql запроса, условие выборки (без WHERE)
	 * @param string $fields    - фрагмент sql запроса, выбираемые поля, нге обязательно указывать id parent_id они включаются из соотв. аргументов
	 * @param string $join - фрагмент sql запроса, присоединение других таблиц
	 * @param string $group_by  - фрагмент sql запроса
	 * @param string $order_by  - фрагмент sql запроса
	 * @param int $id_field_name
	 * @param int $parent_id_field_name
	 * @return tree
	**/
	public function buildTree($condition, $fields = '*', $join = '', $group_by = '', $order_by = '', $id_field_name = 'id', $parent_id_field_name = 'parent_id', $childs = 'childs') {
		$cache_key = APP_ROOT . '/files/cache/' . md5($condition);
		if (file_exists($cache_key) && (strtotime(now()) -  filemtime($cache_key) <= APP_CACHE_LIFE) ) {
			return json_decode( file_get_contents($cache_key) );
		}
		
		$id = $id_field_name;
		$parent_id = $parent_id_field_name;
		
		if ($fields != '*') {
			$fields = "{$this->_table}.{$id}, {$this->_table}.{$parent_id}, {$fields}";
		}
		
		$sql = "SELECT {$fields} FROM {$this->_table} {$join} WHERE {$condition} {$group_by} {$order_by}";
		$raw_data = query($sql);
		if ( !count($raw_data) ) {
			return $raw_data;
		}

		$data = array();
		$search_tree = new SearchTree();
		$i = 0;
		foreach ($raw_data as $key => $item) {
			$data[$item[$id]] = $item;
			if ($i == 0) {
				$search_tree->first($item[$id], $item);
				$i++;
			} else {
				$search_tree->searchAdd($item[$id], true, $item);
			}
		}
		$result = array();
		foreach ($data as $key => $item) {
			$node = $search_tree->searchAdd($key, false);//new SearchTreeNode($key, $item);
			//$ctrl = 0;
			while (true) {
				if ($node->content[$parent_id] == 0 && !isset($result[$node->content[$id]])) {
					$result[$node->content[$id]] = $node->content;
				}
				if ($node->content[$parent_id] == 0) {
					break;
				}
				$parent_node = $search_tree->searchAdd($node->content[$parent_id], false);
				if ($parent_node === false){
					throw new Exception("Неожиданно не найден элемент с id {$node->content[$id]} в бинарном дереве поиска");
				}
				if (!isset($parent_node->content[$childs])) {
					$parent_node->content[$childs] = array();
				}
				$parent_node->content[$childs][$node->content[$id]] = $node->content;
				$success = $search_tree->replaceContent($parent_node->content[$id], $parent_node->content);

				$node = $parent_node;
				if ($node->content[$parent_id] == 0 ) {
					$result[$node->content[$id]] = $node->content;
				}
			}
		}
		if ($node->content[$parent_id] == 0) {
			$result[$node->content[$id]] = $node->content;
		}
		file_put_contents($cache_key, json_encode($result));
		return $result;
	}
	/**
	 * @desc Получить поля для апдейта
	 * @param  $id Идентификатор записи
	 * @param  string $additional_fields перечисление сеоез запятую дополнительных плоей
	 * @return $row | false row Содержит выборку полей заданных для update и поле на которое назначен первичный ключ
	**/
	public function getRecord($id, $additional_fields = false) {
		$id = (int)$id;
		$fields = join(', ', $this->_update) . ', ' . $this->_id_field_name;
		if ($additional_fields) {
			$fields .= ', ' . $additional_fields;
		}
		$sql_query = 'SELECT '. $fields . ' FROM ' . $this->_table . ' WHERE ' . $this->_id_field_name . ' = ' . $id;
		$row = dbrow($sql_query, $numRow);
		if (!$numRow) {
			return false;
		}
		return $row;
	}
	/*
	 * function fullscreen3(element) {
  if(element.requestFullScreen) {
    element.requestFullScreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  }
}
	 * 
	 * */
}