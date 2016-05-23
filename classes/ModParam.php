<?
// require_once('BaseEntity.php');
class ModParam extends BaseEntity
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'gb_cms_catalog_mods_params',
            'id' => 'mps_id'
/*    		'default' => array(
    			'licenseR' => 0,
    			'licenseE' => 0,
    			'licenseD' => 0,
    			'visibility' => 1,
    			'position' => 1,
    			'date_reg' => date("Y-m-d H:i:s"),
    			'date_edit' => date("Y-m-d H:i:s"),
    			'editor' => 1,
			)
*/		));

	}

}