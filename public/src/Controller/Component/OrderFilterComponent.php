<?php

/**
 * OrderFilter component
 *
 * Manages order and filtering of lists.
 * 
 * Keeps user filters in Cookies.
 * 
 * Usage:
 * 
 * In the controller do:
 * $this->paginate = $this->OrderFilter->getPaginationOptions();
 * before calling $this->paginate(MODEL);
 * If you need more pagination options, add them after that line
 * 
 * If it exists, the OrderFilterComponent will call a function
 * Controller::{$conditionsFunction}($data) passing the contents
 * of $this->request->data to create additional conditions.
 * Expects an array that works in $paginate['conditions']
 * 
 * @version       0.1.5
 * @modifiedby    wsb
 * @lastmodified  2023-01-31
 */

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Inflector;


class OrderFilterComponent extends Component
{
	/**
	 * Name of the Cookie to keep the filter data
	 *
	 * @var string
	 * @access public
	 * @default $modelName.'Filter'
	 */
	public $filterName = null;
	/**
	 * Name of the Model to filter and order
	 *
	 * @var string
	 * @access public
	 * @default singularized Controller name
	 */
	public $modelName = null;
	/**
	 * Limit of results to display
	 *
	 * @var int
	 * @access public
	 */
	public $limit = null;
	/**
	 * Default order to display
	 *
	 * @var array
	 * @access public
	 */
	public $defaultOrder = array();
	/**
	 * Default filter to display
	 *
	 * @var array
	 * @access public
	 */
	public $defaultFilter = array();
	/**
	 * Filter data to evaluate
	 *
	 * @var array
	 * @access public
	 */
	public $data = array();
	/**
	 * Pointer to the Controller object calling the OrderFilterComponent
	 *
	 * @var pointer to object
	 * @access public
	 */
	public $controller = null;

	/**
	 * Name of the function to get the Conditions from
	 *
	 * @var string
	 * @access public
	 * @default 'getConditions'
	 */
	public $conditionsFunction = 'getConditions';

	/**
	 * Initializes OrderFilterComponent for use in the controller
	 *
	 * @param object $controller A reference to the instantiating controller object
	 * @param array $settings Additional settings to apply
	 * @return void
	 * @access public
	 */
	public function initialize(array $settings): void
	{
		$this->controller = $this->getController();

		//$settings['limit'] = 1;

		if (isset($settings['modelName'])) {
			$this->modelName = $settings['modelName'];
		} else {

			$this->modelName = Inflector::pluralize(strtolower($this->controller->getName()));
		}

		$this->filterName = $this->modelName . 'Filter';

		if (isset($settings['defaultOrder'])) {
			$this->defaultOrder = $settings['defaultOrder'];
		}
		if (isset($settings['defaultFilter'])) {
			$this->defaultFilter = $settings['defaultFilter'];
		}
		if (isset($settings['limit'])) {
			$this->limit = $settings['limit'];
		}
		if (isset($settings['conditionsFunction'])) {
			$this->conditionsFunction = $settings['conditionsFunction'];
		}
		
	}

	/**
	 * Persist a value in Cookies
	 *
	 * @param string $name Name of the Cookie
	 * @param mixed $value Value to store
	 * @return void
	 * @access public
	 */
	function persistWrite($name, $value = '')
	{
		setcookie($name, json_encode($value), time() + (86400 * 1), "/"); // 86400 = 1 day

	}
	/**
	 * Retrieves persisted value in Cookies
	 *
	 * @param string $name Name of the Cookie
	 * @return persisted data if any, or empty string
	 * @access public
	 */
	function persistRead($name)
	{
		//debug($name);
		//debug($_COOKIE);
		if (isset($_COOKIE[$name])) {
			$cookie = json_decode($_COOKIE[$name], true);
		} else {
			$cookie = '';
		}

		//debug($cookie);

		return $cookie;
	}

	/**
	 * Deletes persisted value in Cookies
	 *
	 * @param string $name Name of the Cookie
	 * @return void
	 * @access public
	 */
	function persistDelete($name)
	{
		//$this->Cookie->delete($name);
		$this->persistWrite($name, '');
	}

	/**
	 * Sets all Filter data and persists it in a Cookie
	 *
	 * @param string $filter Name of the Filter
	 * @return void
	 * @access private
	 */
	private function _saveFilterData($filter)
	{
		//debug($filter);
		//debug(isset($this->controller->getRequest()->getData[$filter]['default']) and $this->controller->getRequest()->getData[$filter]['default']);
		//debug($this->controller->getRequest()->getData());die;
		//if ($this->controller->getRequest()->getData($filter)) {
		if (isset($this->controller->getRequest()->getData[$filter]['default']) and $this->controller->getRequest()->getData[$filter]['default']) {
			$this->persistWrite($filter . 'Data', $this->defaultFilter);
		} else {
			$this->persistWrite($filter . 'Data', $this->controller->getRequest()->getData());
		}
		//}
	}

	/**
	 * Gets all Filter data persisted in a Cookie, if any, or default Filter data
	 *
	 * @param string $filter Name of the Filter
	 * @return Filter data
	 * @access private
	 */
	private function _getFilterData($filter)
	{
		//debug($filter);
		//debug( $this->persistRead($filter . 'Data'));
		//debug($this->controller->getRequest()->getData($filter));
		//debug($this->controller->getRequest()->getData());die;
		//if ($this->persistRead($filter . 'Data')) {
		//	$this->controller->getRequest()->getData[$filter] = $this->persistRead($filter . 'Data');
		//} else {
		//	$this->controller->getRequest()->getData[$filter] = $this->defaultFilter;
		//}

		//debug($_COOKIE);
		//debug( $this->persistRead($filter . 'Data'));
		//debug($this->controller->getRequest()->getData());
		//return $this->persistRead($filter . 'Data');
		return $this->controller->getRequest()->getData();
	}

	/**
	 * Gets all Filter data persisted in a Cookie, if any, or default Filter data from $filterName
	 *
	 * @return Filter Data
	 * @access public
	 */
	function getFilterData()
	{
		return $this->_getFilterData($this->filterName);
	}

	/**
	 * Sets the Order and persist it in a Cookie
	 *
	 * @param string $filter Name of the Filter
	 * @param string $orderField Field to order by
	 * @param string $asc Ascendent or descendent order. Accepted values: ('asc','desc')
	 * @return void
	 * @access private
	 */
	private function _setOrder($filter, $orderField = 'fecha', $asc = 'asc')
	{

		if ($orderField) {
			// If it's the same field, inverts the ordering
			if ($orderField == $this->persistRead($filter . 'Field')) {
				$asc = $this->persistRead($filter . 'Ordering') == 'asc' ? 'desc' : 'asc';
			}
			$this->persistWrite($filter . 'Field', $orderField);
			$this->persistWrite($filter . 'Ordering', $asc);
		} else if (isset($this->defaultOrder['Field']) and isset($this->defaultOrder['Ordering'])) {
			$this->persistWrite($filter . 'Field', $this->defaultOrder['Field']);
			$this->persistWrite($filter . 'Ordering', $this->defaultOrder['Ordering']);
		}
	}

	/**
	 * Gets the Order persisted in a Cookie, if any, or default Order
	 *
	 * @param string $filter Name of the Filter
	 * @return Order to be used in Cake query (array($field => [asc|desc]))
	 * @access private
	 */
	private function _getOrder($filter)
	{
		if ($this->persistRead($filter . '.Field') and $this->persistRead($filter . '.Ordering')) {
			return array($this->persistRead($filter . '.Field') => $this->persistRead($filter . '.Ordering'));
		} else {
			if (isset($this->defaultOrder['Field']) and isset($this->defaultOrder['Ordering'])) {
				return array($this->defaultOrder['Field'] => $this->defaultOrder['Ordering']);
			} else {
				return array();
			}
		}
	}

	/**
	 * Saves the Page to retrieve it after an AJAX event (like a delete)
	 *
	 * @return void
	 * @access private
	 */
	private function _savePage()
	{
		if (!is_null($this->controller->getRequest()->getQuery('page'))) {
			$this->persistWrite($this->modelName . 'Page', $this->controller->getRequest()->getQuery('page'));
		} else {
			$this->persistDelete($this->modelName . 'Page');
		}
	}
	/**
	 * Gets the Field to be Ordered by persisted in a Cookie, if any, or default Field
	 *
	 * @param string $filter Name of the Filter
	 * @return Field to be ordered by
	 * @access private
	 */
	private function _getOrderField($filter)
	{
		$orderField = $this->persistRead($filter . 'Field');
		return $orderField != "" ? $orderField : $this->defaultOrder['Field'];
	}

	/**
	 * Get Pagination Options from persisted or default data.
	 *
	 * @return Pagination conditios array to be used in Cake query
	 * @access public
	 */
	function getPaginationOptions()
	{
		$this->_saveFilterData($this->filterName);		
		$this->_setOrder($this->filterName, $orderField = '', $asc = 'asc');
		$this->controller->set('filterName', $this->filterName);
						
		$conditions = array();

		if (method_exists($this->controller, $this->conditionsFunction)) {
			$conditions = $this->controller->{$this->conditionsFunction}($this->_getFilterData($this->filterName));				
			//debug($this->modelName);die;	
			$query = $this->controller->fetchTable($this->modelName)->find(
				'all',
				conditions: $conditions['conditions'],	
				contain:$conditions['contain'],
				order:  $this->_getOrder($this->filterName),
				
				

			);
			$paginate['query'] = $query;			
			//$paginate['limit']  = $this->limit			;
		}

		// Vacío estas variables para que el paginate no tome el orden por su cuenta
		//unset($this->controller->request->params['named']['sort']);
		//unset($this->controller->request->params['named']['direction']);

		$this->_savePage();	
			
		//debug($paginate);die;				
		return $paginate;
	}

	/**
	 * Clears the filter saved in the cookies
	 *
	 * @return void
	 * @access public
	 */
	function clearFilter()
	{
		$this->persistDelete($this->filterName . 'Data');
		$this->persistDelete($this->filterName . 'Field');
		$this->persistDelete($this->filterName . 'Ordering');
	}
}
