<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationJoin extends Model
{
    //1景点,2目的地，3路线,4节日，5酒店,6餐厅
    const DESTINATION_JOIN_TYPE_A = 1;
    const DESTINATION_JOIN_TYPE_B = 3;
    const DESTINATION_JOIN_TYPE_C = 5;
    const DESTINATION_JOIN_TYPE_D = 6;

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'destination_join';

    /**
     * 黑名单，包含不能被赋值的属性数组
     *
     * @var array
     */
    protected $guarded = ['destination_join_id'];

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = array (
  'destination_join_id' => 'int',
  'destination_id' => 'int',
  'join_id' => 'int',
  'destination_join_sort' => 'int',
  'destination_join_type' => 'int',
);

    //获取目的地下第一张图片
    public static function getOneJoinImg($destinationId)
    {

        $data = self::select('join_id', 'destination_join_type')
            ->where('destination_id', '=', $destinationId)
            ->where('destination_join_type', '=', self::DESTINATION_JOIN_TYPE_A)
            ->orderBy('destination_join_sort')
            ->first();
        if (!$data) {
            return '';
        }
        
        //获取第一张图片
        $img = Img::getOneImg($data->join_id, $data->destination_join_type);

        return $img;

    }

    //获取目的地下所有关联数据
    public function getJoinData($destinationId)
    {
        $data = self::select('join_id','destination_join_type','destination_join_sort')
            ->where('destination_id','=',$destinationId)->get()->toArray();
        return $data;
    }

}
