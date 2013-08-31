<?php
require 'Map.php';
class GoogleMap extends Map{
	/**
	 * 谷歌地图：根据地址获取该地址的经纬度
	 */
	public function g_AddressToLatLng($address){
		$url='http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.$address;
		$result=file_get_contents($url);
		$xml_data=json_decode($result);
		$lnglat=$xml_data->results[0]->geometry->location;
		return (string)($lnglat->lng)."#".(string)($lnglat->lat);
	}
	/**
	 * 谷歌地图：谷歌地图经纬度转换成百度地图经纬度
	 */
	public function g_ConvertLatLng($lat,$lng){
		$url="http://api.map.baidu.com/ag/coord/convert?from=2&to=4&x=".$lat."&y=".$lng;
		$result=file_get_contents($url);
		$result=json_decode($result);
		if($result->error==0){
			$lng=base64_decode($result->y);
			$lat=base64_decode($result->x);
		}
		return $lng."#".$lat;
	}
}