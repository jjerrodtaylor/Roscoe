<?php
/**
 * Tree behavior class.
 *
 * Enables a model object to act as a node-based tree.
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework (http://cakephp.org)
 * Copyright 2006-2010, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2006-2010, Cake Software Foundation, Inc.
 * @link          http://cakephp.org CakePHP Project
 * @package       cake
 * @subpackage    cake.cake.libs.model.behaviors
 * @since         CakePHP v 1.2.0.4487
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Tree Behavior.
 *
 * Enables a model object to act as a node-based tree. Using Modified Preorder Tree Traversal
 *
 * @see http://en.wikipedia.org/wiki/Tree_traversal
 * @package       cake
 * @subpackage    cake.cake.libs.model.behaviors
 * @link http://book.cakephp.org/view/1339/Tree
 */
class TreeBehavior extends ModelBehavior {

/**
 * Errors
 *
 * @var array
 */
	var $errors = array();

/**
 * Defaults
 *
 * @var array
 * @access protected
 */
	var $_defaults = array(
		'parent' => 'parent_id', 'left' => 'lft', 'right' => 'rght',
		'scope' => '1 = 1', 'type' => 'nested', '__parentChange' => false, 'recursive' => -1
	);

/**
 * Initiate Tree behavior
 *
 * @param object $Model instance of model
 * @param array $config array of configuration settings.
 * @return void
 * @access public
 */
	function setup(&$Model, $config = array()) {
		if (!is_array($config)) {
			$config = array('type' => $config);
		}
		$settings = array_merge($this->_defaults, $config);

		if (in_array($settings['scope'], $Model->getAssociated('belongsTo'))) {
			$data = $Model->getAssociated($settings['scope']);
			$parent =& $Model->{$settings['scope']};
			$settings['scope'] = $Model->alias . '.' . $data['foreignKey'] . ' = ' . $parent->alias . '.' . $parent->primaryKey;
			$settings['recursive'] = 0;
		}
		$this->settings[$Model->alias] = $settings;
	}

/**
 * After save method. Called after all saves
 *
 * Overriden to transparently manage setting the lft and rght fields if and only if the parent field is included in the
 * parameters to be saved.
 *
 * @param AppModel $Model Model instance.
 * @param boolean $created indicates whether the node just saved was created or updated
 * @return boolean true on success, false on failure
 * @access public
 */
	function afterSave(&$Model, $created) {
		extract($this->settings[$Model->alias]);
		if ($created) {
			if ((isset($Model->data[$Model->alias][$parent])) && $Model->data[$Model->alias][$parent]) {
				return $this->_setParent($Model, $Model->data[$Model->alias][$parent], $created);
			}
		} elseif ($__parentChange) {
			$this->settings[$Model->alias]['__parentChange'] = false;
			return $this->_setParent($Model, $Model->data[$Model->alias][$parent]);
		}
	}

/**
 * Before delete method. Called before all deletes
 *
 * Will delete the current node and all children using the deleteAll method and sync the table
 *
 * @param AppModel $Model Model instance
 * @return boolean true to continue, false to abort the delete
 * @access public
 */
	function beforeDelete(&$Model) {
		extract($this->settings[$Model->alias]);
		list($name, $data) = array($Model->alias, $Model->read());
		$data = $data[$name];

		if (!$data[$right] || !$data[$left]) {
			return true;
		}
		$diff = $data[$right] - $data[$left] + 1;

		if ($diff > 2) {
			if (is_string($scope)) {
				$scope = array($scope);
			}
			$scope[]["{$Model->alias}.{$left} BETWEEN ? AND ?"] = array($data[$left] + 1, $data[$right] - 1);
			$Model->deleteAll($scope);
		}
		$this->__sync($Model, $diff, '-', '> ' . $data[$right]);
		return true;
	}

/**
 * Before save method. Called before all saves
 *
 * Overriden to transparently manage setting the lft and rght fields if and only if the parent field is included in the
 * parameters to be saved. For newly created nodes with NO parent the left and right field values are set directly by
 * this method bypassing the setParent logic.
 *
 * @since         1.2
 * @param AppModel $Model Model instance
 * @return boolean true to continue, false to abort the save
 * @access public
 */
	function beforeSave(&$Model) {
		extract($this->settings[$Model->alias]);

		$this->_addToWhitelist($Model, array($left, $right));
		if (!$Model->id) {
			if (array_key_exists($parent, $Model->data[$Model->alias]) && $Model->data[$Model->alias][$parent]) {
				$parentNode = $Model->find('first', array(
					'conditions' => array($scope, $Model->escapeField() => $Model->data[$Model->alias][$parent]),
					'fields' => array($Model->primaryKey, $right), 'recursive' => $recursive
				));
				if (!$parentNode) {
					return false;
				}
				list($parentNode) = array_values($parentNode);
				$Model->data[$Model->alias][$left] = 0; //$parentNode[$right];
				$Model->data[$Model->alias][$right] = 0; //$parentNode[$right] + 1;
			} else {
				$edge = $this->__getMax($Model, $scope, $right, $recursive);
				$Model->data[$Model->alias][$left] = $edge + 1;
				$Model->data[$Model->alias][$right] = $edge + 2;
			}
		} elseif (array_key_exists($parent, $Model->data[$Model->alias])) {
			if ($Model->data[$Model->alias][$parent] != $Model->field($parent)) {
				$this->settings[$Model->alias]['__parentChange'] = true;
			}
			if (!$Model->data[$Model->alias][$parent]) {
				$Model->data[$Model->alias][$parent] = null;
				$this->_addToWhitelist($Model, $parent);
			} else {
				$values = $Model->find('first', array(
					'conditions' => array($scope,$Model->escapeField() => $Model->id),
					'fields' => array($Model->primaryKey, $parent, $left, $right ), 'recursive' => $recursive)
				);

				if ($values === false) {
					return false;
				}
				list($node) = array_values($values);

				$parentNode = $Model->find('first', array(
					'conditions' => array($scope, $Model->escapeField() => $Model->data[$Model->alias][$parent]),
					'fields' => array($Model->primaryKey, $left, $right), 'recursive' => $recursive
				));
				if (!$parentNode) {
					return false;
				}
				list($parentNode) = array_values($parentNode);

				if (($node[$left] < $parentNode[$left]) && ($parentNode[$right] < $node[$right])) {
					return false;
				} elseif ($node[$Model->primaryKey] == $parentNode[$Model->primaryKey]) {
					return false;
				}
			}
		}
		return true;
	}

/**
 * Get the number of child nodes
 *
 * If the direct parameter is set to true, only the direct children are counted (based upon the parent_id field)
 * If false is passed for the id parameter, all top level nodes are counted, or all nodes are counted.
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to read or false to read all top level nodes
 * @param boolean $direct whether to count direct, or all, children
 * @return integer number of child nodes
 * @access public
 * @link http://book.cakephp.org/view/1347/Counting-children
 */
	function childcount(&$Model, $id = null, $direct = false) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		extract($this->settings[$Model->alias]);

		if ($direct) {
			return $Model->find('count', array('conditions' => array($scope, $Model->escapeField($parent) => $id)));
		}

		if ($id === null) {
			return $Model->find('count', array('conditions' => $scope));
		} elseif (isset($Model->data[$Model->alias][$left]) && isset($Model->data[$Model->alias][$right])) {
			$data = $Model->data[$Model->alias];
		} else {
			$data = $Model->find('first', array('conditions' => array($scope, $Model->escapeField() => $id), 'recursive' => $recursive));
			if (!$data) {
				return 0;
			}
			$data = $data[$Model->alias];
		}
		return ($data[$right] - $data[$left] - 1) / 2;
	}

/**
 * Get the child nodes of the current model
 *
 * If the direct parameter is set to true, only the direct children are returned (based upon the parent_id field)
 * If false is passed for the id parameter, top level, or all (depending on direct parameter appropriate) are counted.
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to read
 * @param boolean $direct whether to return only the direct, or all, children
 * @param mixed $fields Either a single string of a field name, or an array of field names
 * @param string $order SQL ORDER BY conditions (e.g. "price DESC" or "name ASC") defaults to the tree order
 * @param integer $limit SQL LIMIT clause, for calculating items per page.
 * @param integer $page Page number, for accessing paged data
 * @param integer $recursive The number of levels deep to fetch associated records
 * @return array Array of child nodes
 * @access public
 * @link http://book.cakephp.org/view/1346/Children
 */
	function children(&$Model, $id = null, $direct = false, $fields = null, $order = null, $limit = null, $page = 1, $recursive = null) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		$overrideRecursive = $recursive;

		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		$name = $Model->alias;
		extract($this->settings[$Model->alias]);

		if (!is_null($overrideRecursive)) {
			$recursive = $overrideRecursive;
		}
		if (!$order) {
			$order = $Model->alias . '.' . $left . ' asc';
		}
		if ($direct) {
			$conditions = array($scope, $Model->escapeField($parent) => $id);
			return $Model->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive'));
		}

		if (!$id) {
			$conditions = $scope;
		} else {
			$result = array_values((array)$Model->find('first', array(
				'conditions' => array($scope, $Model->escapeField() => $id),
				'fields' => array($left, $right),
				'recursive' => $recursive
			)));

			if (empty($result) || !isset($result[0])) {
				return array();
			}
			$conditions = array($scope,
				$Model->escapeField($right) . ' <' => $result[0][$right],
				$Model->escapeField($left) . ' >' => $result[0][$left]
			);
		}
		return $Model->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive'));
	}

/**
 * A convenience method for returning a hierarchical array used for HTML select boxes
 *
 * @param AppModel $Model Model instance
 * @param mixed $conditions SQL conditions as a string or as an array('field' =>'value',...)
 * @param string $keyPath A string path to the key, i.e. "{n}.Post.id"
 * @param string $valuePath A string path to the value, i.e. "{n}.Post.title"
 * @param string $spacer The character or characters which will be repeated
 * @param integer $recursive The number of levels deep to fetch associated records
 * @return array An associative array of records, where the id is the key, and the display field is the value
 * @access public
 * @link http://book.cakephp.org/view/1348/generatetreelist
 */
	function generatetreelist(&$Model, $conditions = null, $keyPath = null, $valuePath = null, $spacer = '_', $recursive = null) {
		//echo $conditions ;
		//die();
		$overrideRecursive = $recursive;
		extract($this->settings[$Model->alias]);
		if (!is_null($overrideRecursive)) {
			$recursive = $overrideRecursive;
		}

		if ($keyPath == null && $valuePath == null && $Model->hasField($Model->displayField)) {
			$fields = array($Model->primaryKey, $Model->displayField, $left, $right);
		} else {
			$fields = null;
		}

		if ($keyPath == null) {
			$keyPath = '{n}.' . $Model->alias . '.' . $Model->primaryKey;
		}

		if ($valuePath == null) {
			$valuePath = array('{0}{1}', '{n}.tree_prefix', '{n}.' . $Model->alias . '.' . $Model->displayField);

		} elseif (is_string($valuePath)) {
			$valuePath = array('{0}{1}', '{n}.tree_prefix', $valuePath);

		} else {
			$valuePath[0] = '{' . (count($valuePath) - 1) . '}' . $valuePath[0];
			$valuePath[] = '{n}.tree_prefix';
		}
		$order = $Model->alias . '.' . $left . ' asc';
		$results = $Model->find('all', compact('conditions', 'fields', 'order', 'recursive'));
		$stack = array();

		foreach ($results as $i => $result) {
			while ($stack && ($stack[count($stack) - 1] < $result[$Model->alias][$right])) {
				array_pop($stack);
			}
			$results[$i]['tree_prefix'] = str_repeat($spacer,count($stack));
			$stack[] = $result[$Model->alias][$right];
		}
		if (empty($results)) {
			return array();
		}
		return Set::combine($results, $keyPath, $valuePath);
		
		
	}

/**
 * Get the parent node
 *
 * reads the parent id and returns this node
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to read
 * @param integer $recursive The number of levels deep to fetch associated records
 * @return array Array of data for the parent node
 * @access public
 * @link http://book.cakephp.org/view/1349/getparentnode
 */
	function getparentnode(&$Model, $id = null, $fields = null, $recursive = null) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		$overrideRecursive = $recursive;
		if (empty ($id)) {
			$id = $Model->id;
		}
		extract($this->settings[$Model->alias]);
		if (!is_null($overrideRecursive)) {
			$recursive = $overrideRecursive;
		}
		$parentId = $Model->find('first', array('conditions' => array($Model->primaryKey => $id), 'fields' => array($parent), 'recursive' => -1));

		if ($parentId) {
			$parentId = $parentId[$Model->alias][$parent];
			$parent = $Model->find('first', array('conditions' => array($Model->escapeField() => $parentId), 'fields' => $fields, 'recursive' => $recursive));

			return $parent;
		}
		return false;
	}

/**
 * Get the path to the given node
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to read
 * @param mixed $fields Either a single string of a field name, or an array of field names
 * @param integer $recursive The number of levels deep to fetch associated records
 * @return array Array of nodes from top most parent to current node
 * @access public
 * @link http://book.cakephp.org/view/1350/getpath
 */
	function getpath(&$Model, $id = null, $fields = null, $recursive = null) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		$overrideRecursive = $recursive;
		if (empty ($id)) {
			$id = $Model->id;
		}
		extract($this->settings[$Model->alias]);
		if (!is_null($overrideRecursive)) {
			$recursive = $overrideRecursive;
		}
		$result = $Model->find('first', array('conditions' => array($Model->escapeField() => $id), 'fields' => array($left, $right), 'recursive' => $recursive));
		if ($result) {
			$result = array_values($result);
		} else {
			return null;
		}
		$item = $result[0];
		$results = $Model->find('all', array(
			'conditions' => array($scope, $Model->escapeField($left) . ' <=' => $item[$left], $Model->escapeField($right) . ' >=' => $item[$right]),
			'fields' => $fields, 'order' => array($Model->escapeField($left) => 'asc'), 'recursive' => $recursive
		));
		return $results;
	}

/**
 * Reorder the node without changing the parent.
 *
 * If the node is the last child, or is a top level node with no subsequent node this method will return false
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to move
 * @param mixed $number how many places to move the node or true to move to last position
 * @return boolean true on success, false on failure
 * @access public
 * @link http://book.cakephp.org/view/1352/moveDown
 */
	function movedown(&$Model, $id = null, $number = 1) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		if (!$number) {
			return false;
		}
		if (empty ($id)) {
			$id = $Model->id;
		}
		extract($this->settings[$Model->alias]);
		list($node) = array_values($Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField() => $id),
			'fields' => array($Model->primaryKey, $left, $right, $parent), 'recursive' => $recursive
		)));
		if ($node[$parent]) {
			list($parentNode) = array_values($Model->find('first', array(
				'conditions' => array($scope, $Model->escapeField() => $node[$parent]),
				'fields' => array($Model->primaryKey, $left, $right), 'recursive' => $recursive
			)));
			if (($node[$right] + 1) == $parentNode[$right]) {
				return false;
			}
		}
		$nextNode = $Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField($left) => ($node[$right] + 1)),
			'fields' => array($Model->primaryKey, $left, $right), 'recursive' => $recursive)
		);
		if ($nextNode) {
			list($nextNode) = array_values($nextNode);
		} else {
			return false;
		}
		$edge = $this->__getMax($Model, $scope, $right, $recursive);
		$this->__sync($Model, $edge - $node[$left] + 1, '+', 'BETWEEN ' . $node[$left] . ' AND ' . $node[$right]);
		$this->__sync($Model, $nextNode[$left] - $node[$left], '-', 'BETWEEN ' . $nextNode[$left] . ' AND ' . $nextNode[$right]);
		$this->__sync($Model, $edge - $node[$left] - ($nextNode[$right] - $nextNode[$left]), '-', '> ' . $edge);

		if (is_int($number)) {
			$number--;
		}
		if ($number) {
			$this->moveDown($Model, $id, $number);
		}
		return true;
	}

/**
 * Reorder the node without changing the parent.
 *
 * If the node is the first child, or is a top level node with no previous node this method will return false
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to move
 * @param mixed $number how many places to move the node, or true to move to first position
 * @return boolean true on success, false on failure
 * @access public
 * @link http://book.cakephp.org/view/1353/moveUp
 */
	function moveup(&$Model, $id = null, $number = 1) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		if (!$number) {
			return false;
		}
		if (empty ($id)) {
			$id = $Model->id;
		}
		extract($this->settings[$Model->alias]);
		list($node) = array_values($Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField() => $id),
			'fields' => array($Model->primaryKey, $left, $right, $parent ), 'recursive' => $recursive
		)));
		if ($node[$parent]) {
			list($parentNode) = array_values($Model->find('first', array(
				'conditions' => array($scope, $Model->escapeField() => $node[$parent]),
				'fields' => array($Model->primaryKey, $left, $right), 'recursive' => $recursive
			)));
			if (($node[$left] - 1) == $parentNode[$left]) {
				return false;
			}
		}
		$previousNode = $Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField($right) => ($node[$left] - 1)),
			'fields' => array($Model->primaryKey, $left, $right),
			'recursive' => $recursive
		));

		if ($previousNode) {
			list($previousNode) = array_values($previousNode);
		} else {
			return false;
		}
		$edge = $this->__getMax($Model, $scope, $right, $recursive);
		$this->__sync($Model, $edge - $previousNode[$left] +1, '+', 'BETWEEN ' . $previousNode[$left] . ' AND ' . $previousNode[$right]);
		$this->__sync($Model, $node[$left] - $previousNode[$left], '-', 'BETWEEN ' .$node[$left] . ' AND ' . $node[$right]);
		$this->__sync($Model, $edge - $previousNode[$left] - ($node[$right] - $node[$left]), '-', '> ' . $edge);
		if (is_int($number)) {
			$number--;
		}
		if ($number) {
			$this->moveUp($Model, $id, $number);
		}
		return true;
	}

/**
 * Recover a corrupted tree
 *
 * The mode parameter is used to specify the source of info that is valid/correct. The opposite source of data
 * will be populated based upon that source of info. E.g. if the MPTT fields are corrupt or empty, with the $mode
 * 'parent' the values of the parent_id field will be used to populate the left and right fields. The missingParentAction
 * parameter only applies to "parent" mode and determines what to do if the parent field contains an id that is not present.
 *
 * @todo Could be written to be faster, *maybe*. Ideally using a subquery and putting all the logic burden on the DB.
 * @param AppModel $Model Model instance
 * @param string $mode parent or tree
 * @param mixed $missingParentAction 'return' to do nothing and return, 'delete' to
 * delete, or the id of the parent to set as the parent_id
 * @return boolean true on success, false on failure
 * @access public
 * @link http://book.cakephp.org/view/1628/Recover
 */
	function recover(&$Model, $mode = 'parent', $missingParentAction = null) {
		if (is_array($mode)) {
			extract (array_merge(array('mode' => 'parent'), $mode));
		}
		extract($this->settings[$Model->alias]);
		$Model->recursive = $recursive;
		if ($mode == 'parent') {
			$Model->bindModel(array('belongsTo' => array('VerifyParent' => array(
				'className' => $Model->alias,
				'foreignKey' => $parent,
				'fields' => array($Model->primaryKey, $left, $right, $parent),
			))));
			$missingParents = $Model->find('list', array(
				'recursive' => 0,
				'conditions' => array($scope, array(
					'NOT' => array($Model->escapeField($parent) => null), $Model->VerifyParent->escapeField() => null
				))
			));
			$Model->unbindModel(array('belongsTo' => array('VerifyParent')));
			if ($missingParents) {
				if ($missingParentAction == 'return') {
					foreach ($missingParents as $id => $display) {
						$this->errors[]	= 'cannot find the parent for ' . $Model->alias . ' with id ' . $id . '(' . $display . ')';

					}
					return false;
				} elseif ($missingParentAction == 'delete') {
					$Model->deleteAll(array($Model->primaryKey => array_flip($missingParents)));
				} else {
					$Model->updateAll(array($parent => $missingParentAction), array($Model->escapeField($Model->primaryKey) => array_flip($missingParents)));
				}
			}
			$count = 1;
			foreach ($Model->find('all', array('conditions' => $scope, 'fields' => array($Model->primaryKey), 'order' => $left)) as $array) {
				$Model->id = $array[$Model->alias][$Model->primaryKey];
				$lft = $count++;
				$rght = $count++;
				$Model->save(array($left => $lft, $right => $rght), array('callbacks' => false));
			}
			foreach ($Model->find('all', array('conditions' => $scope, 'fields' => array($Model->primaryKey, $parent), 'order' => $left)) as $array) {
				$Model->create();
				$Model->id = $array[$Model->alias][$Model->primaryKey];
				$this->_setParent($Model, $array[$Model->alias][$parent]);
			}
		} else {
			$db =& ConnectionManager::getDataSource($Model->useDbConfig);
			foreach ($Model->find('all', array('conditions' => $scope, 'fields' => array($Model->primaryKey, $parent), 'order' => $left)) as $array) {
				$path = $this->getpath($Model, $array[$Model->alias][$Model->primaryKey]);
				if ($path == null || count($path) < 2) {
					$parentId = null;
				} else {
					$parentId = $path[count($path) - 2][$Model->alias][$Model->primaryKey];
				}
				$Model->updateAll(array($parent => $db->value($parentId, $parent)), array($Model->escapeField() => $array[$Model->alias][$Model->primaryKey]));
			}
		}
		return true;
	}

/**
 * Reorder method.
 *
 * Reorders the nodes (and child nodes) of the tree according to the field and direction specified in the parameters.
 * This method does not change the parent of any node.
 *
 * Requires a valid tree, by default it verifies the tree before beginning.
 *
 * Options:
 *
 * - 'id' id of record to use as top node for reordering
 * - 'field' Which field to use in reordeing defaults to displayField
 * - 'order' Direction to order either DESC or ASC (defaults to ASC)
 * - 'verify' Whether or not to verify the tree before reorder. defaults to true.
 *
 * @param AppModel $Model Model instance
 * @param array $options array of options to use in reordering.
 * @return boolean true on success, false on failure
 * @link http://book.cakephp.org/view/1355/reorder
 * @link http://book.cakephp.org/view/1629/Reorder
 */
	function reorder(&$Model, $options = array()) {
		$options = array_merge(array('id' => null, 'field' => $Model->displayField, 'order' => 'ASC', 'verify' => true), $options);
		extract($options);
		if ($verify && !$this->verify($Model)) {
			return false;
		}
		$verify = false;
		extract($this->settings[$Model->alias]);
		$fields = array($Model->primaryKey, $field, $left, $right);
		$sort = $field . ' ' . $order;
		$nodes = $this->children($Model, $id, true, $fields, $sort, null, null, $recursive);

		$cacheQueries = $Model->cacheQueries;
		$Model->cacheQueries = false;
		if ($nodes) {
			foreach ($nodes as $node) {
				$id = $node[$Model->alias][$Model->primaryKey];
				$this->moveDown($Model, $id, true);
				if ($node[$Model->alias][$left] != $node[$Model->alias][$right] - 1) {
					$this->reorder($Model, compact('id', 'field', 'order', 'verify'));
				}
			}
		}
		$Model->cacheQueries = $cacheQueries;
		return true;
	}

/**
 * Remove the current node from the tree, and reparent all children up one level.
 *
 * If the parameter delete is false, the node will become a new top level node. Otherwise the node will be deleted
 * after the children are reparented.
 *
 * @param AppModel $Model Model instance
 * @param mixed $id The ID of the record to remove
 * @param boolean $delete whether to delete the node after reparenting children (if any)
 * @return boolean true on success, false on failure
 * @access public
 * @link http://book.cakephp.org/view/1354/removeFromTree
 */
	function removefromtree(&$Model, $id = null, $delete = false) {
		if (is_array($id)) {
			extract (array_merge(array('id' => null), $id));
		}
		extract($this->settings[$Model->alias]);

		list($node) = array_values($Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField() => $id),
			'fields' => array($Model->primaryKey, $left, $right, $parent),
			'recursive' => $recursive
		)));

		if ($node[$right] == $node[$left] + 1) {
			if ($delete) {
				return $Model->delete($id);
			} else {
				$Model->id = $id;
				return $Model->saveField($parent, null);
			}
		} elseif ($node[$parent]) {
			list($parentNode) = array_values($Model->find('first', array(
				'conditions' => array($scope, $Model->escapeField() => $node[$parent]),
				'fields' => array($Model->primaryKey, $left, $right),
				'recursive' => $recursive
			)));
		} else {
			$parentNode[$right] = $node[$right] + 1;
		}

		$db =& ConnectionManager::getDataSource($Model->useDbConfig);
		$Model->updateAll(
			array($parent => $db->value($node[$parent], $parent)), 
			array($Model->escapeField($parent) => $node[$Model->primaryKey])
		);
		$this->__sync($Model, 1, '-', 'BETWEEN ' . ($node[$left] + 1) . ' AND ' . ($node[$right] - 1));
		$this->__sync($Model, 2, '-', '> ' . ($node[$right]));
		$Model->id = $id;

		if ($delete) {
			$Model->updateAll(
				array(
					$Model->escapeField($left) => 0,
					$Model->escapeField($right) => 0,
					$Model->escapeField($parent) => null
				),
				array($Model->escapeField() => $id)
			);
			return $Model->delete($id);
		} else {
			$edge = $this->__getMax($Model, $scope, $right, $recursive);
			if ($node[$right] == $edge) {
				$edge = $edge - 2;
			}
			$Model->id = $id;
			return $Model->save(
				array($left => $edge + 1, $right => $edge + 2, $parent => null),
				array('callbacks' => false)
			);
		}
	}

/**
 * Check if the current tree is valid.
 *
 * Returns true if the tree is valid otherwise an array of (type, incorrect left/right index, message)
 *
 * @param AppModel $Model Model instance
 * @return mixed true if the tree is valid or empty, otherwise an array of (error type [index, node],
 *  [incorrect left/right index,node id], message)
 * @access public
 * @link http://book.cakephp.org/view/1630/Verify
 */
	function verify(&$Model) {
		extract($this->settings[$Model->alias]);
		if (!$Model->find('count', array('conditions' => $scope))) {
			return true;
		}
		$min = $this->__getMin($Model, $scope, $left, $recursive);
		$edge = $this->__getMax($Model, $scope, $right, $recursive);
		$errors =  array();

		for ($i = $min; $i <= $edge; $i++) {
			$count = $Model->find('count', array('conditions' => array(
				$scope, 'OR' => array($Model->escapeField($left) => $i, $Model->escapeField($right) => $i)
			)));
			if ($count != 1) {
				if ($count == 0) {
					$errors[] = array('index', $i, 'missing');
				} else {
					$errors[] = array('index', $i, 'duplicate');
				}
			}
		}
		$node = $Model->find('first', array('conditions' => array($scope, $Model->escapeField($right) . '< ' . $Model->escapeField($left)), 'recursive' => 0));
		if ($node) {
			$errors[] = array('node', $node[$Model->alias][$Model->primaryKey], 'left greater than right.');
		}

		$Model->bindModel(array('belongsTo' => array('VerifyParent' => array(
			'className' => $Model->alias,
			'foreignKey' => $parent,
			'fields' => array($Model->primaryKey, $left, $right, $parent)
		))));

		foreach ($Model->find('all', array('conditions' => $scope, 'recursive' => 0)) as $instance) {
			if (is_null($instance[$Model->alias][$left]) || is_null($instance[$Model->alias][$right])) {
				$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey],
					'has invalid left or right values');
			} elseif ($instance[$Model->alias][$left] == $instance[$Model->alias][$right]) {
				$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey],
					'left and right values identical');
			} elseif ($instance[$Model->alias][$parent]) {
				if (!$instance['VerifyParent'][$Model->primaryKey]) {
					$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey],
						'The parent node ' . $instance[$Model->alias][$parent] . ' doesn\'t exist');
				} elseif ($instance[$Model->alias][$left] < $instance['VerifyParent'][$left]) {
					$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey],
						'left less than parent (node ' . $instance['VerifyParent'][$Model->primaryKey] . ').');
				} elseif ($instance[$Model->alias][$right] > $instance['VerifyParent'][$right]) {
					$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey],
						'right greater than parent (node ' . $instance['VerifyParent'][$Model->primaryKey] . ').');
				}
			} elseif ($Model->find('count', array('conditions' => array($scope, $Model->escapeField($left) . ' <' => $instance[$Model->alias][$left], $Model->escapeField($right) . ' >' => $instance[$Model->alias][$right]), 'recursive' => 0))) {
				$errors[] = array('node', $instance[$Model->alias][$Model->primaryKey], 'The parent field is blank, but has a parent');
			}
		}
		if ($errors) {
			return $errors;
		}
		return true;
	}

/**
 * Sets the parent of the given node
 *
 * The force parameter is used to override the "don't change the parent to the current parent" logic in the event
 * of recovering a corrupted table, or creating new nodes. Otherwise it should always be false. In reality this
 * method could be private, since calling save with parent_id set also calls setParent
 *
 * @param AppModel $Model Model instance
 * @param mixed $parentId
 * @return boolean true on success, false on failure
 * @access protected
 */
	function _setParent(&$Model, $parentId = null, $created = false) {
		extract($this->settings[$Model->alias]);
		list($node) = array_values($Model->find('first', array(
			'conditions' => array($scope, $Model->escapeField() => $Model->id),
			'fields' => array($Model->primaryKey, $parent, $left, $right),
			'recursive' => $recursive
		)));
		$edge = $this->__getMax($Model, $scope, $right, $recursive, $created);

		if (empty ($parentId)) {
			$this->__sync($Model, $edge - $node[$left] + 1, '+', 'BETWEEN ' . $node[$left] . ' AND ' . $node[$right], $created);
			$this->__sync($Model, $node[$right] - $node[$left] + 1, '-', '> ' . $node[$left], $created);
		} else {
			$values = $Model->find('first', array(
				'conditions' => array($scope, $Model->escapeField() => $parentId),
				'fields' => array($Model->primaryKey, $left, $right),
				'recursive' => $recursive
			));

			if ($values === false) {
				return false;
			}
			$parentNode = array_values($values);

			if (empty($parentNode) || empty($parentNode[0])) {
				return false;
			}
			$parentNode = $parentNode[0];

			if (($Model->id == $parentId)) {
				return false;

			} elseif (($node[$left] < $parentNode[$left]) && ($parentNode[$right] < $node[$right])) {
				return false;
			}
			if (empty ($node[$left]) && empty ($node[$right])) {
				$this->__sync($Model, 2, '+', '>= ' . $parentNode[$right], $created);
				$result = $Model->save(
					array($left => $parentNode[$right], $right => $parentNode[$right] + 1, $parent => $parentId),
					array('validate' => false, 'callbacks' => false)
				);
				$Model->data = $result;
			} else {
				$this->__sync($Model, $edge - $node[$left] +1, '+', 'BETWEEN ' . $node[$left] . ' AND ' . $node[$right], $created);
				$diff = $node[$right] - $node[$left] + 1;

				if ($node[$left] > $parentNode[$left]) {
					if ($node[$right] < $parentNode[$right]) {
						$this->__sync($Model, $diff, '-', 'BETWEEN ' . $node[$right] . ' AND ' . ($parentNode[$right] - 1), $created);
						$this->__sync($Model, $edge - $parentNode[$right] + $diff + 1, '-', '> ' . $edge, $created);
					} else {
						$this->__sync($Model, $diff, '+', 'BETWEEN ' . $parentNode[$right] . ' AND ' . $node[$right], $created);
						$this->__sync($Model, $edge - $parentNode[$right] + 1, '-', '> ' . $edge, $created);
					}
				} else {
					$this->__sync($Model, $diff, '-', 'BETWEEN ' . $node[$right] . ' AND ' . ($parentNode[$right] - 1), $created);
					$this->__sync($Model, $edge - $parentNode[$right] + $diff + 1, '-', '> ' . $edge, $created);
				}
			}
		}
		return true;
	}

/**
 * get the maximum index value in the table.
 *
 * @param AppModel $Model
 * @param string $scope
 * @param string $right
 * @return int
 * @access private
 */
	function __getMax($Model, $scope, $right, $recursive = -1, $created = false) {
		$db =& ConnectionManager::getDataSource($Model->useDbConfig);
		if ($created) {
			if (is_string($scope)) {
				$scope .= " AND {$Model->alias}.{$Model->primaryKey} <> ";
				$scope .= $db->value($Model->id, $Model->getColumnType($Model->primaryKey));
			} else {
				$scope['NOT'][$Model->alias . '.' . $Model->primaryKey] = $Model->id;
			}
		}
		$name = $Model->alias . '.' . $right;
		list($edge) = array_values($Model->find('first', array(
			'conditions' => $scope,
			'fields' => $db->calculate($Model, 'max', array($name, $right)),
			'recursive' => $recursive
		)));
		return (empty($edge[$right])) ? 0 : $edge[$right];
	}

/**
 * get the minimum index value in the table.
 *
 * @param AppModel $Model
 * @param string $scope
 * @param string $right
 * @return int
 * @access private
 */
	function __getMin($Model, $scope, $left, $recursive = -1) {
		$db =& ConnectionManager::getDataSource($Model->useDbConfig);
		$name = $Model->alias . '.' . $left;
		list($edge) = array_values($Model->find('first', array(
			'conditions' => $scope,
			'fields' => $db->calculate($Model, 'min', array($name, $left)),
			'recursive' => $recursive
		)));
		return (empty($edge[$left])) ? 0 : $edge[$left];
	}

/**
 * Table sync method.
 *
 * Handles table sync operations, Taking account of the behavior scope.
 *
 * @param AppModel $Model
 * @param integer $shift
 * @param string $direction
 * @param array $conditions
 * @param string $field
 * @access private
 */
	function __sync(&$Model, $shift, $dir = '+', $conditions = array(), $created = false, $field = 'both') {
		$ModelRecursive = $Model->recursive;
		extract($this->settings[$Model->alias]);
		$Model->recursive = $recursive;

		if ($field == 'both') {
			$this->__sync($Model, $shift, $dir, $conditions, $created, $left);
			$field = $right;
		}
		if (is_string($conditions)) {
			$conditions = array("{$Model->alias}.{$field} {$conditions}");
		}
		if (($scope != '1 = 1' && $scope !== true) && $scope) {
			$conditions[] = $scope;
		}
		if ($created) {
			$conditions['NOT'][$Model->alias . '.' . $Model->primaryKey] = $Model->id;
		}
		$Model->updateAll(array($Model->alias . '.' . $field => $Model->escapeField($field) . ' ' . $dir . ' ' . $shift), $conditions);
		$Model->recursive = $ModelRecursive;
	}
}
