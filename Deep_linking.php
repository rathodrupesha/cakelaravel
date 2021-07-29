
<?php

/*****get shorter url through curl in firebase
 * NOte: generate shrot url, on click of that it will redirect into app & on particular page in app
 * 
 * Steps: https://console.firebase.google.com/project/iqchain-e8553/settings/general/
& do authenticate so it will be create webapi key. make sure you need to create proj in firebase

   https://firebase.google.com/docs/dynamic-links/rest
 *  https://firebase.google.com/docs/dynamic-links/create-manually   =sussess
 * 
 * 
 * 
 * 
 * ********/
function shorten_URL($longUrl)
{
    $key = 'XXXXXXXXXXX';
    // $url = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=&#8217;'.$key;
    $url = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key='.$key;

    $data = array(
                  'dynamicLinkInfo' => array(
                                               'domainUriPrefix' => 'https://app.myiqchain.net',
                                               'link' => $longUrl,
                                               //'androidInfo'=>array('androidPackageName'=>'com.app.iqchain'),//new
                                               //'iosInfo'=>array('iosBundleId'=>'com.iqchain'),//new
                                             )
                 );
// echo "<pre>";print_r(json_encode($data));exit;
    $headers = array('Content-Type: application/json');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $data = curl_exec($ch);
    curl_close($ch);

    $short_url = json_decode($data);
    if (isset($short_url->error)) {
        return $short_url->error->message;
    } else {
        return $short_url->shortLink;
    }
}

$replacements = ['!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]",".","_"];
$entities = ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D','%2E','%5F'];
              



$amv=1;             // android min version num
$isi=str_replace($replacements, $entities, urlencode('284815942'));     //app store id
$ifl=str_replace($replacements, $entities, urlencode('myiqchain.net')); //fallback id

$ibi=str_replace($replacements, $entities, urlencode('com.app.iqchain'));      //bundel id
$imv=str_replace($replacements, $entities, urlencode('1.0.0'));                   //ios min version
$link=str_replace($replacements, $entities, urlencode('https://www.keyocs.com?coupon_id=438')); //make coupon id dynamic
$apn=str_replace($replacements, $entities, urlencode('com.iqchain'));     //andorid package name
$ius='';    //optional
$url='https://app.myiqchain.net/';
$splEnd='&';
$qryStringExpression='?';

$queryString='isi='.$isi.$splEnd.'ifl='.$ifl.$splEnd.'ibi='.$ibi.$splEnd.'imv='.$imv.$splEnd.'link='.$link.$splEnd.'amv='.$amv.$splEnd.'apn='.$apn;

$url=$url.$qryStringExpression.$queryString;

// Call to function with the LongURL
echo shorten_URL($url);


// echo shorten_URL('https://app.myiqchain.net/?amv=1&ibi=com%2Eapp%2Eiqchain&apn=com%2Eiqchain&imv=1%2E0%2E0&ifl=myiqchain%2Enet&link=https%3A%2F%2Fwww%2Ekeyocs%2Ecom%3Fcoupon%5Fid%3D437');



/*

DEMO

https://example.page.link/?link=https://www.example.com/someresource&apn=com.example.android&amv=3&ibi=com.example.ios&isi=1234567&ius=exampleapp



OUR

https://app.myiqchain.net/?isi=284815942&ifl=myiqchain%2Enet&ibi=com%2Eapp%2Eiqchain&imv=1%2E0%2E0&link=https%3A%2F%2Fwww%2Ekeyocs%2Ecom%3Fcoupon%5Fid%3D204&amv=1&apn=com%2Eiqchain

https://app.myiqchain.net/?isi=284815942&ifl=myiqchain%2Enet&ibi=com%2Eapp%2Eiqchain&imv=1%2E0%2E0&link=https%3A%2F%2Fwww%2Ekeyocs%2Ecom%3Fcoupon%5Fid%3D438&amv=1&apn=com%2Eiqchain

made by php

https://app.myiqchain.net/?isi=284815942&ifl=myiqchain.net&ibi=com.app.iqchain&imv=1.0.0&link=https://www.keyocs.com?coupon_id=438&1&apn=com.iqchain

made by php  with url encoded





amv=1             // android min version num
isi=284815942     //app store id
ifl=myiqchain.net //fallback id
ibi=com.app.iqchain      //bundel id
imv=1.0.0                   //ios min version
link=https://www.keyocs.com?coupon_id=438
apn=com.iqchain     //andorid package name
ius=    //optional



*/
  






//FOR JAVASCRITPT use below for make ulr encoding & etc

//https://stackoverflow.com/questions/15604140/replace-multiple-strings-with-multiple-other-strings

//https://meyerweb.com/eric/tools/dencoder/

//https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/encodeURIComponent
