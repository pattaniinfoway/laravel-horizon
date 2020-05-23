<?php

namespace App\Http\Repository;
use DB;
use Illuminate\Support\Facades\Storage;
abstract class RepositoryAbstract  
{
    public function storeS3Image($data){  
        Storage::disk('s3')->put($data['file_path'], $data['file'], 'public');
    }
    public function deleteS3Image($data){ 
        Storage::disk('s3')->delete($data['file_path'], $data['file'], 'public');
    }
    // #fetch data
    // Protected function getData($table){  
    //    $data = DB::table($table)->get()->toArray(); 
    //    return $data;       
    // }
    // #add data
    // Protected function save($table,$data){  
    //    $addData = DB::table($table)->insertGetId($data); 
    //    return $addData;       
    // } 
    // #update data  
    // Protected function update($table,$data,$id){
    //    $updateData = DB::table($table)->where('id', $id)->update($data);
    //    return $updateData;
    // }
    #delete data
    // Protected function delete($table,$id){  
    //    $deleteData = DB::table($table)->where('id',$id)->delete();
    //    return $deleteData; 
    // }
    // public function getAllStatus(){ 
    //     return ['1' => 'Ordered','2' => 'Accepted & Processed','3' => 'Packed','4' => 'Shipped','5' => 'Intransit','6' => 'Delivered',];   
    // }
    // /*-------------return status--------------*/  
    // public function getAllReturnStatus(){   
    //     return ['9' => 'Return requested','10' => 'Return accepted','11' => 'Return picked up','12' => 'Return received by BU','15' => 'Return Reject','13' => 'Refund initiated','14' => 'Refund Complete'];       
    // }
}
 