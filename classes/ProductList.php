<?
// require_once('BaseEntity.php');
class ProductList extends BaseEntity 
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'product_list'
		));

	}

}