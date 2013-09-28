<?php

/**
* EOCAutoTagComponent
*
* Based on Dan Grossman's opencalais class
* Using Open Calais service
*
* @author Wilson He <wilson.he@gmail.com>
* @version 0.1
* @copyright Copyright &copy; 2009 Wilson he
* @license BSD
*
*/
class EOCAutoTagComponentException extends CException {}

class EOCAutoTagComponent extends CApplicationComponent
{
    /**
     * @var string  The API key for using Open Calais' service.
     */
    public $oc_api_key=null;

    /**
     * @var string  The tag delimiter for return string. Defaults as comma(,).
     */
    public $tag_delimiter = ',';
    /**
     * @var Object  The instance of opencalais object.
     */
    private $oc = null;


	/**
	 * @param	string	$oc_api_key
	 * @param	string	$tag_delimiter
	 */
	public function __construct($oc_api_key=null, $tag_delimiter=null)
	{
		$this->oc_api_key = $oc_api_key;
		if(!empty($tag_delimiter))
			 $this->tag_delimiter = $tag_delimiter;

	}

    /**
	 * Initializes the component.
	 * This method is required by {@link IApplicationComponent} and is invoked by application
	 * when the EOCAutoTagComponent is used as an application component.
	 * If you override this method, make sure to call the parent implementation
	 * so that the component can be marked as initialized.
	 */
	public function init()
	{
		parent::init();

    	if(empty($this->oc_api_key))
    		throw new EOCAutoTagComponentException(Yii::t('OCAutoTag',"You must provide an Open Calais API key to use OCAutoTag extension."));
    	else{
    		require_once('dg_open_calais/opencalais.php');
    		$this->oc = new OpenCalais($this->oc_api_key);
    	}
	}

	/**
	 * @param	string	$content	Input content string
	 * @return  string  Return tags seperated by tag_delimeter or false if no tag generated
	 */
	public function getTags($content)
	{
		$entities = $this->oc->getEntities($content);
		if(empty($entities))
		  	return false;
		$res_array = array();
    	foreach ($entities as $type => $values) {
    		foreach ($values as $entity) {
    			$res_array[] = $entity;
    		}
    	}
		return implode($this->tag_delimiter,$res_array);
	}

	/**
	 * @return string Return tag_delimeter
	 */
	public function getTagDelimiter()
	{
		return $this->tag_delimiter;
	}
}