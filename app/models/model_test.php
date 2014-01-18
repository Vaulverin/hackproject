<?
class Model_Test extends Model
{
    public function show_test_data()
    {
        $arr = array(
            "title"=>"Test title",
            "data"=>"Some data is here",
            "array"=> array(
                0 => "item 0",
                1 => "item 1",
                3 => array(0 => 'array in array in array oO')
            )
        );
        generateJSONReply($arr);
    }

}