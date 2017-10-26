@php
  $json=[];
  $json['@context'] = "http://schema.org";
  $json["@type"] = "LocalBusiness";
  $json['name'] = $data['title']['name'];
  if(isset($data['images'])) {
    $json['image'] = $data['images'][0]['thumb'];
    $json['photos'] = [];
    foreach($data['images'] as $photo) $json['photos'][] = $photo['thumb'];
  }
  if(isset($data['address'])) $json['address'] = [ 
    "@type"=> "PostalAddress",
    "streetAddress" => $data['address'],
    "addressLocality" => $data['city']['area'],
    "addressRegion" => $data['city']['name'],
    "addressCountry" => "India",
  ];
  $json['url'] = $data['title']['url'];
  if(isset($data['location'])) $json['geo'] = [
    "@type" => "GeoCoordinates",
    "latitude" => $data['location']['lat'],
    "longitude" => $data['location']['lng'],
  ];
  $json['telephone'] = [];
  if(isset($data['contact']['mobile']))foreach($data['contact']['mobile'] as $mobile){
    $json['telephone'][] = $mobile['value'];
  }
  if(isset($data['contact']['landline']))foreach($data['contact']['landline'] as $landline){
    $json['telephone'][] = $landline['value'];
  }
  if(isset($data['showHours']) and $data['showHours'] == 1){
    $json['openingHoursSpecification'] = [];
    foreach($data['hours'] as $day){
      $json['openingHoursSpecification'][] = [
        "@type" => "OpeningHoursSpecification",
        "closes" =>  $day['to'],
        "dayOfWeek" => "http://schema.org/".$day['day'],
        "opens" =>  $day['from'],
      ];
    }
  }
  if(isset($data['highlights'])){
    $json['hasOfferCatalog'] = [
      "@type" => "OfferCatalog",
      "name" => "Highlights",
      "itemListElement" => [],
    ];
    foreach($data['highlights'] as $highlight){
      $json['hasOfferCatalog']["itemListElement"][] = [
        "@type" => "OfferCatalog",
        "name" => $highlight
      ];
    }
  }
  $json['paymentAccepted'] = [];
  if(isset($data['payments'])) foreach($data['payments'] as $payment){
    $json['paymentAccepted'][] = $payment;
  }
  /* if(isset($data['rating'])){
    $json['aggregateRating'] = [
      "@type" => "AggregateRating",
      "ratingValue" => "3.0", //between 1 to 5
      "ratingCount" => "1"   //Number of people voting
    ];
  } */
@endphp

<script type="application/ld+json">{!!json_encode($json)!!}</script>

