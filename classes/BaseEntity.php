<?
// defined('HOMEINDEX') || define('HOMEINDEX', true);
// require_once($_SERVER['DOCUMENT_ROOT'] . '/gbcatalog/class/classSQL.php');
require_once(___root.'class/classSQL.php');


class BaseEntity
{
	private
		$tableName = false,
		$id = false,
		$defaultValues = array();

    public function __construct($params) {
    	$this->tableName = $params['table'];
    	$this->id = ( !empty($params['id']) ? $params['id'] : 'id' );
    	$this->defaultValues = ( !empty($params['default']) ? $params['default'] : array() );
		// pr_var($this, 'this');
	}

	/**
	 * @param
	 */
	public function add($params)
	{
		$params = array_merge($this->defaultValues, $params);
		// pr_var($params, 'params');
		// pr_var( j('SQL'), 'j_SQL');
		return j('SQL')->set($this->tableName, $params);
	}

	public function update($params)
	{
		return j('SQL')->set($this->tableName, $params['values'], $this->_getWhere($params['where']));
	}

	public function upsert($params)
	{
		// pr_var($params, 'params');
		// pr_var(j('SQL')->infoWhere($params['where']), 'info');
		return j('SQL')->set($this->tableName, $params['values'], $this->_getWhere($params['where']));
		/*
		if ($item = $this->getRow($params['where'])) {
			$result = $item['id'];
			$this->update($params);
		} else {
			$result = $this->add($params);
		}
		return $result;
		*/
	}

	public function getList($params)
	{
		if ( empty($params) ) {
			$params = array();
		}
		if ( empty($params['select']) ) {
			$params['select'] = '*';
		} else {
			$fields = explode(',',str_replace(' ', '', $params['select']));
			if ( !in_array($this->id, $fields) ) {
				$params['select'] = $this->id .',' . $params['select'];
			}
		}

		$list = $this->_getData($params);
		// pr_var($list, '$list');

		foreach ($list as $key => $value) {
			$result[$value[$this->id]] = $value;
		}

		return $result;
	}

	public function getRow($params)
	{
		$params['limit'] = array(0, 1);
		return current($this->getList($params));
	}

	public function delete($where)
	{
		return j('SQL')->delete($this->tableName, $where);
	}

	public function getListByQuery($query)
	{
		// echo '<br>', $query, '<br>';
		if ( method_exists(j('SQL'), 'execQuery') ) {
			$data = j('SQL')->execQuery($query);
		} else {
			$data = j('SQL')->query($query);
		}

		$result = array();
		while ($el = mysql_fetch_assoc($data)) {
			$result[$el[$this->id]] = $el;
		}

		return $result;
	}

	public function getRowByQuery($query)
	{
		return current($this->getListByQuery($query));
	}


	private function _getData($params)
	{
		if ( method_exists(j('SQL'), 'get') ) {
			$more = array(
				'limit' => $params['limit'],
				'group' => $params['group'],
				'order' => $params['order']
			);

			$result = j('SQL')->get($this->tableName, $params['select'], $params['where'], $more, false);
		} else {
			// pr_var($params['where'], 'params');
			$more = '';
			if ( !empty($params['order']) ) {
				$more .= ' order by ' . join(',', $params['order']);
			}

			$where = $this->_getWhere($params['where']);
			$result = j('SQL')->getData(
				$this->tableName,
				$params['select'],
				( !empty($where) ? $where : '1' ),
				$more,
				$this->id
			);
		}
		return $result;
	}

	private function _getWhere($params)
	{
		$result = '';
		if (is_array($params) && count($params)) {
			foreach ($params as $key => $value) {
				$result .= $key;
				$result .= ( is_array($value)
					? ' in (' . join(',', $value) . ')'
					: '="' . $value . '"'
				);
				$result .=  ' and ';
			}
			$result .= '1';
		}
		return $result;
	}

}