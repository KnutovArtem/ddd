<?php

/**
 * @var object $conn ;
 * @var string $day;
 * @var string $date;
 */

include('dbconn/dbconfig.php');
include('dbconn/checkemail.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$email = $_POST['email'];
$skintype = $_POST['skintype'];
$promo = $_POST['promocode'];
if ($_POST['test'] ?? '') {
    print_r($_POST);
}
if ($conn->connect_error) {
    die('{"status": "dberror"}');
    file_put_contents("log/$day-errors-base.txt", "\n$conn->error\n USER: $date, $email, $promo, $skintype", FILE_APPEND | LOCK_EX);
} else {
    if($skintype != 'false') {
        $data = "<operation>
  <customer>
    <email>$email</email>
<customFields>
        <lRPSkinType>
            <value>$skintype</value>
        </lRPSkinType>
</customFields>

<subscriptions>
      <subscription>
        <brand>LaRochePosay</brand>
        <pointOfContact>Email</pointOfContact>
 <isSubscribed>true</isSubscribed>
      </subscription>
    </subscriptions>
  </customer>
  <customerAction>
    <customFields>
<promokodBFLrp>$promo</promokodBFLrp>
  </customFields>
</customerAction>
<pointOfContact>Web_LRP_WebOwnSite_BrandWebsite_LandingPage_BlackFriday_11.2021_Standard </pointOfContact>
</operation>";

        $url  = 'https://api.mindbox.ru/v3/operations/sync?endpointId=LRPWebhook&operation=issuedPromoBF2021';

        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/xml",
            "Accept: text/xml",
            'Authorization: Mindbox secretKey="dG9SF527yNWrPhaePMT5"'
        ) );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec( $curl );
        if ( curl_errno( $curl ) ) {
            throw new Exception( curl_error( $curl ) );
        }

        $xml  = simplexml_load_string( $result );
        $json = json_encode( $xml );

        echo $json;
        file_put_contents("log/$day-success.txt", "Success USER: $date, 'not_connected', $email, $promo, $skintype", FILE_APPEND | LOCK_EX);
    } else {
        $emailExist = checkEmail($email, $conn);
        if ($emailExist) {
            echo '{"status": "exist"}';
        } else {
            $data = "<operation>
                      <customer>
                         <email>$email</email>
                               <subscriptions>
                          <subscription>
                            <brand>LaRochePosay</brand>
                            <pointOfContact>Email</pointOfContact>
                            <valueByDefault>true</valueByDefault>
                            <isSubscribed>true</isSubscribed>
                          </subscription>    
                        </subscriptions> 
                    
                      </customer>
                     
                    <pointOfContact>Web_LRP_WebOwnSite_BrandWebsite_LandingPage_BlackFriday_11.2021_Standard </pointOfContact>
                    </operation>";

            $url  = 'https://api.mindbox.ru/v3/operations/sync?endpointId=LRPWebhook&operation=DobavilEmailBFLrp2021';

            $curl = curl_init( $url );
            curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/xml",
                "Accept: text/xml",
                'Authorization: Mindbox secretKey="dG9SF527yNWrPhaePMT5"'
            ) );
            curl_setopt( $curl, CURLOPT_POST, true );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
            $result = curl_exec( $curl );
            if ( curl_errno( $curl ) ) {
                throw new Exception( curl_error( $curl ) );
            }

            $xml  = simplexml_load_string( $result );
            $json = json_encode( $xml );

            echo $json;
        }
    }
}



