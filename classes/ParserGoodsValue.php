<?
require_once( $_SERVER['DOCUMENT_ROOT'] . '/parser_loc/phpQuery-onefile.php');

function my_conv ($str) {
    return iconv('UTF-8', 'ISO-8859-1', $str);
}

class ParserGoodsValue
{

    public function __construct() {

    }

    public function parse($url) {
        $page = phpQuery::newDocumentFileHTML($url);

        $product = $page->find('div.product-info > div');
        
        $gallery_row = pq($product)->find('#gallery > ul > li > img');
        foreach ($gallery_row as $g) {
            $g_item = pq($g)->attr('src');
            $gallery[] = preg_replace('/-\d+x\d+\./', '-600x600.', $g_item);
        }
        if(count($gallery) == 0){
            $gallery[] = pq($product)->find('#gallery span.zoom > img:first-child')->attr('src');
        }

        $productDesc = explode('<span>', my_conv(pq($product)->find('.product-desc')->html())); 
        foreach ($productDesc as $key => $value) {
            if ($key > 0) {
                $attrs = explode(':', strip_tags($value) );
                $info[$attrs[0]] = $attrs[1];
            }
        }

        $productPropsContainer = pq($product)->find('section.product-info tbody>tr');
        foreach ($productPropsContainer as $key => $value) {
            $attrs = explode(PHP_EOL, my_conv($value->textContent));
            $productProps[trim($attrs[0])] = trim($attrs[1]);
        }
        $productPrice = strip_tags(preg_replace('/[^0-9]/', '', pq($product)->find('div.caption-full div.product-price')->text()));

        return array(
            'price' => $productPrice,
            'images' => $gallery,
            'attrs' => $info,
            'props' => $productProps
        );
    }
}