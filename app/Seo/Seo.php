<?php
/**
$seoFileName ->file path of seo page 'App\Seo\JobSingleView'
$additionaldata -> additional info related to page eg: [id=>1]
*/
function getMetaTags($seoFileName,$additionaldata=[]){

	$seoFile = new $seoFileName($additionaldata) ;
	$metaData = $seoFile->getMetaData($seoFileName,$additionaldata);

	return \View::make('seo.metatags')->with(["ogtag"=>$metaData['ogTag'], "twitterTag"=>$metaData['twitterTag'], "itemPropTag"=>$metaData['itemPropTag'],"tags"=>$metaData['tags'],"page"=>$metaData['page']])->render();
}


function getPageBreadcrum($seoFileName,$additionaldata=[]){
 
	$seoFile = new $seoFileName($additionaldata) ;
	$breadcrumbs = $seoFile->getBreadcrum($seoFileName,$additionaldata);

	return \View::make('seo.breadcrumb')->with(["breadcrumbs"=>$breadcrumbs])->render();
}

function getPageLdJson($seoFileName,$additionaldata=[]){
 
	$seoFile = new $seoFileName($additionaldata) ;
	$ldJsons = $seoFile->getLdJson($seoFileName,$additionaldata);

	return \View::make('seo.ld-json')->with(["ldJsons"=>$ldJsons])->render();
}


