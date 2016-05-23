<?
// require_once('BaseEntity.php');
class Goods extends BaseEntity 
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
                'editor' => 1
            )
        ));

    }

    public function getGeneration($parentId) {
        
        $list = $this->getRow(array(
            'select' => 'heir, generation',
            'where' => array('id' => $parentId)
        ));

        // $list = $this->_testGetList($parentId);
        // pr_var($list, 'getGeneration list');


        
        /*
        $result = '[1:' . $parentId . ']';
        if ( $list['generation'] != '') {
            $generation = explode(',', $list['generation']);
            foreach ($generation as $value) {
                $value  = explode(':', strtr($value, array('[' => '',']' => '')));
                $result .= ',['.($value[0] + 1) . ':' . $value[1] . ']';
            } 
        }

        return $result;
        */
        return $this->getGenerationEx($parentId, $list['generation']);
    }

    public function getGenerationEx($parentId, $generation) {
        $result = '[1:' . $parentId . ']';
        if ( $generation != '') {
            $generation = explode(',', $generation);
            foreach ($generation as $value) {
                $value  = explode(':', strtr($value, array('[' => '',']' => '')));
                $result .= ',['.($value[0] + 1) . ':' . $value[1] . ']';
            } 
        }
        return $result;
    }



    private function _testGetList($parentId) {
        
        $list[1] = array(
            'id' => '1',
            'heir' => '', 
            'generation' => ''
        );

        $list[2] = array(
            'id' => '2',
            'heir' => '1', 
            'generation' => '[1:1]'
        );

        $list[3] = array(
            'id' => '3',
            'heir' => '2', 
            'generation' => '[1:2],[2:1]'
        );

        $list[4] = array(
            'id' => '4',
            'heir' => '3', 
            'generation' => '[1:3],[2:2],[3:1]'
        );

        $list[5] = array(
            'id' => '5',
            'heir' => '2', 
            'generation' => '[1:2],[2:1]'
        );

        return $list[$parentId];
    }
}