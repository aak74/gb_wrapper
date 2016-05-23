<?
// require_once('BaseEntity.php');
class GoodsValue extends BaseEntity 
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'gb_ru_catalog_goods_value',
    		'default' => array(
    			'license'=>'50',
    			'visibility'=>'1',
    			'number'=>'1'
			)
		));

	}

}