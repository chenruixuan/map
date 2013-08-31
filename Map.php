<?php
/**
 * 地图的公共方法，googleMap和baiduMap的父类
 * @author ruixuan
 *
 */
class Map {
	/**
	 * 获取两个经纬度之间的距离
	 */
	public function GetDistance($lat1,$lng1,$lat2,$lng2)  
		{  
    		$EARTH_RADIUS = 6378.137;  
    		$radLat1 = $this->rad($lat1);  
   			$radLat2 = $this->rad($lat2);  
   			$a = $radLat1 - $radLat2;  
   			$b = $this->rad($lng1) - $this->rad($lng2);  
   			$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));  
   			$s = $s*$EARTH_RADIUS;  
   			$s = round($s*10000)/10000;  
   			return $s;  
		}
		
	/**
	 * 获取某个经纬度为中心，指定半径的圆的经纬度范围
	 * @param lat 纬度 lon 经度 raidus 半径 单位米
	 */
		
		public function getLatAndLng($lat,$lon,$raidus){
			$PI = 3.14159265;
			$latitude = $lat;
			$longitude = $lon;
			$degree = (24901*1609)/360.0;
			$raidusMile = $raidus;
			$dpmLat = 1/$degree;
			$radiusLat = $dpmLat*$raidusMile;
			$minLat=$latitude-$radiusLat;
			$maxLat = $latitude+$radiusLat;
			
			$mpdLng = $degree*cos($latitude*($PI/180));
			$dpmLng = 1/$mpdLng;
			$radiusLng = $dpmLng*$raidusMile;
			$minLng = $longitude-$radiusLng;
			$maxLng = $longitude + $radiusLng;
			return $minLat."#".$maxLat."#".$minLng."#".$maxLng;
		}
		
		/**
		 * 获取web访客IP
		 */
		public function getIp(){
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
			else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
			else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			$ip = getenv("REMOTE_ADDR"); 
			else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			$ip = $_SERVER['REMOTE_ADDR']; 
			else 
			$ip = "unknown";
			return $ip;
		}
		
		/**
		 * 根据ip获取归属地(淘宝API)
		 */
		public function getAddressByIp($ip){
			$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
			$json_data=file_get_contents($url);
			$xml_data=json_decode($json_data);
			$result=array();
			$result[]=$xml_data->data->country;	//获取国家名称
			$result[]=$xml_data->data->area;	//获取区域名称，如华东
			$result[]=$xml_data->data->region;	//获取省份名称
			$result[]=$xml_data->data->city;	//获取城市名称
			$result[]=$xml_data->data->isp;		//获取运营商名称
			return $result;
		}
		
		/**
		 * 备注：一个web上常用的功能，获取用户ip->ip转换成城市名->城市名转换成经纬度->地图加载时以该经纬度为中心
		 */
		
		
		
		
		 
}

?>