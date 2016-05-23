<?
// require_once('BaseEntity.php');
class GoodsParameter extends BaseEntity 
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'gb_ru_catalog_goods',
    		'default' => array(
    			'licenseR' => 0,
    			'licenseE' => 0,
    			'licenseD' => 0,
    			'visibility' => 1,
    			'position' => 1,
    			'date_reg' => date("Y-m-d H:i:s"),
    			'date_edit' => date("Y-m-d H:i:s"),
    			'editor' => 1,
			)
		));

	}

}