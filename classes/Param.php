<?
// require_once('BaseEntity.php');
class Param extends BaseEntity
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'gb_cms_catalog_params',
            'id' => 'param_id'
		));

	}

}