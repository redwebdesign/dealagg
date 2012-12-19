<?php
class Snapdeal extends Parsing{
	public $_code = 'Snapdeal';

	public function getAllowedCategory(){
		return array(Category::CAMERA,Category::COMP_ACC,Category::COMP_LAPTOP,Category::GAMING,Category::HOME_APPLIANCE,Category::MOBILE,Category::TABLETS,Category::TV,Category::BEAUTY);
	}

	public function getWebsiteUrl(){
		return 'http://www.snapdeal.com/';
	}
	public function getSearchURL($query,$category = false){
		if($category == Category::BEAUTY){
			return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=31&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::BOOKS){
			return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=364&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=cream&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::CAMERA){
			return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=290&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::COMP_ACC || $category == Category::COMP_LAPTOP){
			return "http://www.snapdeal.com/search?keyword=$query&catId=&categoryId=21&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=dslr&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::HOME_APPLIANCE){
			return "http://www.snapdeal.com/search?keyword=$query&catId=0&categoryId=9&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=dslr&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::MOBILE || $category == Category::TABLETS){
			return "http://www.snapdeal.com/search?keyword=$query&catId=0&categoryId=17&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=washing+mat&prodCatId=250&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::TV || $category == Category::GAMING){
			return "http://www.snapdeal.com/search?keyword=$query&catId=0&categoryId=7&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=washing+mat&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
		}else if($category == Category::NUTRITION){
			return "http://www.snapdeal.com/search?keyword=$query&catId=0&categoryId=318&suggested=false&vertical=p&noOfResults=20&clickSrc=go_header&lastKeyword=washing+mat&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=21&url=&utmContent=&catalogID=&dealDetail=";
		}else{
			return "http://www.snapdeal.com/search?keyword=".$query."&catId=&categoryId=0&suggested=false&vertical=&noOfResults=20&clickSrc=go_header&lastKeyword=&prodCatId=&changeBackToAll=false&foundInAll=false&categoryIdSearched=&url=&utmContent=&catalogID=&dealDetail=";
		}
	}
	public function getLogo(){
		return "http://i4.sdlcdn.com/img/snapdeal/sprite/snapdeal_logo_tagline.png";
	}
	public function getData($html,$query,$category){

		$data = array();
		phpQuery::newDocumentHTML($html);
		foreach(pq('div.product_listing_cont') as $div){
			if(sizeof(pq($div)->find('.product-image'))){
				$image = pq($div)->find('.product-image')->html();
				$url = pq($div)->find('a')->attr('href');
				$name = strip_tags(pq($div)->find('.product_listing_heading')->html());
				$org_price = pq($div)->find('.product_listing_price_outer')->find('.originalprice')->html();
				$disc_price = pq($div)->find('.product_listing_price_outer')->find('.product_discount_outer ')->html();
				$data[] = array('name'=>$name,'image'=>$image,'org_price'=>$org_price,'disc_price'=>$disc_price,'url'=>$url,'website'=>$this->getCode());
			}
		}
		$data2 = array();
		foreach($data as $row){
			$html = $row['image'];
			$html .= '</img>';
			phpQuery::newDocumentHTML($html);
			$img = pq('img')->attr('src');
			if(strpos($img, 'http') === false){
				$img = $this->getWebsiteUrl().$img;
			}
			$row['image'] = $img;
			$data2[] = $row;
		}
		return $data2;
	}
}