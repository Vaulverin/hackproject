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
        //generateJSONReply($arr);
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '1997,Ford,E350,"ac, abs, moon",3000.00\n
        1999,Chevy,"Venture ""Extended Edition""","",4900.00\n
1996,Jeep,Grand Cherokee,"MUST SELL! air, moon roof, loaded",4799.00';
    }

}