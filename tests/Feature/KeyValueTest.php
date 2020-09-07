<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\KeyObject;

class KeyValueTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }


    public function testGetValue()
    {
        $keyobj = KeyObject::create(['key_id' => 'asdf123', 
            'value' => 'value123']);

        $response = $this->get('/api/object/asdf123');

        $res_array = (array)json_decode($response->content());

        if(array_key_exists('data', $res_array))
        {
            if(empty($res_array['data']))
            {
               return $this->assertTrue(false);
            }
            else
            {
                return $this->assertTrue(true);
            }

        }
        else
            return $this->assertTrue(false);
    }


    public function testGetValueWithTimeStamp()
    {
        $keyobj = KeyObject::create(['key_id' => 'asdf234', 
            'value' => 'value234']);

        $timestamp = strtotime($keyobj->updated_at);

        $response = $this->get('/api/object/'. $keyobj->key_id.'?timestamp='.$timestamp);

        $res_array = (array)json_decode($response->content());

        if(array_key_exists('data', $res_array))
        {
            if(empty($res_array['data']))
            {
                return $this->assertTrue(false);
            }
            else
            {
                 return $this->assertTrue(true);
            }

        }
        else
            return $this->assertTrue(false);

    }

    public function testGetValueWithNonExistKey()
    {
        $response = $this->get('/api/object/nosuchkey');
        
        $res_array = (array)json_decode($response->content());

        if(array_key_exists('data', $res_array))
        {
            if(empty($res_array['data']))
            {
                return $this->assertTrue(true);
            }
            else
            {
                 return $this->assertTrue(false);
            }
        }
        else
           return $this->assertTrue(false);
    }



    public function testCreateValue()
    {
        $json_data_str = '{"testing 123": "777","testing 456": "888"}';
        $response = $this->post('/object')->setContent($json_data_str);

        $res_data_array = json_decode($response->content(), true);

        if($res_data_array == null)
           return $this->assertTrue(false);

        else
        {
            foreach($res_data_array as  $key => $value)
            {
                if(is_string($value) == true)
                {
                    $key_obj = KeyObject::where('key_id', $key)->first();

                    if($key_obj)
                    {
                        $key_obj->value = $value;
                        $key_obj->save();
                    }
                    else
                    {
                        $key_obj = KeyObject::create([
                            'key_id' => $key,
                            'value' => $value
                        ]);
                    }

                    $verified_obj = KeyObject::where('key_id', $key)->first();

                    if($verified_obj)
                    {
                        if( $verified_obj->value != $value)
                             return $this->assertTrue(false);
                    }
                    else
                        return $this->assertTrue(false);
                }
                else
                    return $this->assertTrue(false);
              
            }

            return $this->assertTrue(true);
        }

        // $response->assertStatus(200);
    }




}
