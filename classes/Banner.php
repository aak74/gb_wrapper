<?
class Banner extends BaseEntity
{

    public function __construct() {
    	parent::__construct(array(
    		'table' => 'gb_cms_banners',
            'id' => 'banner_id'
		));

	}

}