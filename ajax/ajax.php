<?php

class SMSClient {

    public $mode = 'HTTPS'; //HTTP or HTTPS
    protected $_server = '://alphasms.com.ua/api/http.php';
    protected $_errors = array();
    protected $_last_response = array();
    private $_version = '1.7';

    //IN: login, password on platform SMSClub (AlphaSMS)
    public function __construct($login, $password) {
        $this->_login = $login;
        $this->_password = $password;
    }

    //IN: 	sender name, phone of receiver, text message in UTF-8 - if long - will be auto split
    //		send_dt - date-time of sms sending, wap - url for Wap-Push link, flash - for Flash sms.
    //OUT: 	message_id to track delivery status, if empty message_id - check errors via $this->getErrors()
    public function sendSMS($from, $to, $message, $send_dt = 0, $wap = '', $flash = 0) {
        if (!$send_dt)
            $send_dt = date('Y-m-d H:i:s');
        $d = is_numeric($send_dt) ? $send_dt : strtotime($send_dt);
        $data = array('from' => $from,
            'to' => $to,
            'message' => $message,
            'ask_date' => date(DATE_ISO8601, $d),
            'wap' => $wap,
            'flash' => $flash,
            'class_version' => $this->_version);
        $result = $this->execute('send', $data);
        if (count(@$result['errors']))
            $this->_errors = $result['errors'];
        return @$result['id'];
    }

    //IN: 	message_id to track delivery status
    //OUT: 	text name of status
    public function receiveSMS($sms_id) {
        $data = array('id' => $sms_id);
        $result = $this->execute('receive', $data);
        if (count(@$result['errors']))
            $this->_errors = $result['errors'];
        return @$result['status'];
    }

    //OUT:	amount in UAH, if no return - check errors
    public function getBalance() {
        $result = $this->execute('balance');
        if (count(@$result['errors']))
            $this->_errors = $result['errors'];
        return @$result['balance'];
    }

    //OUT:	returns number of errors
    public function hasErrors() {
        return count($this->_errors);
    }

    //OUT:	returns array of errors
    public function getErrors() {
        return $this->_errors;
    }

    public function getResponse() {
        return $this->_last_response;
    }

    public function translit($string) {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ye',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'і' => 'i',
            'и' => 'i', 'й' => 'j', 'к' => 'k', 'ї' => 'yi',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '"',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Є' => 'Ye',
            'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'І' => 'I',
            'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Ї' => 'Yi',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '"',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );
        $result = strtr($string, $converter);

        //upper case if needed
        if (mb_strtoupper($string) == $string)
            $result = mb_strtoupper($result);

        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $result);
    }

    protected function execute($command, $params = array()) {
        $this->_errors = array();

        //HTTP GET
        if (strtolower($this->mode) == 'http') {
            $response = @file_get_contents($this->generateUrl($command, $params));
            return @unserialize($this->base64_url_decode($response));
        } else {
            $params['login'] = $this->_login;
            $params['password'] = $this->_password;
            $params['command'] = $command;
            $params_url = '';
            foreach ($params as $key => $value)
                $params_url .= '&' . $key . '=' . $this->base64_url_encode($value);

            //cURL HTTPS POST
            $ch = curl_init(strtolower($this->mode) . $this->_server);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $response = @curl_exec($ch);
            curl_close($ch);

            $this->_last_response = @unserialize($this->base64_url_decode($response));
            return $this->_last_response;
        }
    }

    protected function generateUrl($command, $params = array()) {
        $params_url = '';
        if (count($params))
            foreach ($params as $key => $value)
                $params_url .= '&' . $key . '=' . $this->base64_url_encode($value);
        $auth = '?login=' . $this->base64_url_encode($this->_login) . '&password=' . $this->base64_url_encode($this->_password);
        $command = '&command=' . $this->base64_url_encode($command);
        return strtolower($this->mode) . $this->_server . $auth . $command . $params_url;
    }

    public function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    public function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

}

function CP1251toUTF8($string) {
    $out = '';
    for ($i = 0; $i < strlen($string); ++$i) {
        $ch = ord($string{$i});
        if ($ch < 0x80)
            $out .= chr($ch);
        else
        if ($ch >= 0xC0)
            if ($ch < 0xF0)
                $out .= "\xD0" . chr(0x90 + $ch - 0xC0); // А-Я, а-п (A-YA, a-p)
            else
                $out .= "\xD1" . chr(0x80 + $ch - 0xF0); // р-я (r-ya)
            
        else
            switch ($ch) {
                case 0xA8: $out .= "\xD0\x81";
                    break; // YO
                case 0xB8: $out .= "\xD1\x91";
                    break; // yo
// ukrainian
                case 0xA1: $out .= "\xD0\x8E";
                    break; // Ў (U)
                case 0xA2: $out .= "\xD1\x9E";
                    break; // ў (u)
                case 0xAA: $out .= "\xD0\x84";
                    break; // Є (e)
                case 0xAF: $out .= "\xD0\x87";
                    break; // Ї (I..)
                case 0xB2: $out .= "\xD0\x86";
                    break; // I (I)
                case 0xB3: $out .= "\xD1\x96";
                    break; // i (i)
                case 0xBA: $out .= "\xD1\x94";
                    break; // є (e)
                case 0xBF: $out .= "\xD1\x97";
                    break; // ї (i..)
// chuvashian
                case 0x8C: $out .= "\xD3\x90";
                    break; // ? (A)
                case 0x8D: $out .= "\xD3\x96";
                    break; // ? (E)
                case 0x8E: $out .= "\xD2\xAA";
                    break; // ? (SCH)
                case 0x8F: $out .= "\xD3\xB2";
                    break; // ? (U)
                case 0x9C: $out .= "\xD3\x91";
                    break; // ? (a)
                case 0x9D: $out .= "\xD3\x97";
                    break; // ? (e)
                case 0x9E: $out .= "\xD2\xAB";
                    break; // ? (sch)
                case 0x9F: $out .= "\xD3\xB3";
                    break; // ? (u)
            }
    }
    return $out;
}

class Ajax_Hendler {

    public $http;

    public function action_index($http) {

        $this->connect();
        $this->ajaxGetHttp($http);
    }

    public function ajaxGetHttp($http) {

        foreach ($http as $key => $type) {
            switch ($key) {
                case 'order':
                    $order = $http['order'];
                    $total = $http['total'];
                    $user = $http['user'];
                    $this->checkout($order, $total, $user);
                    break;
                case 'consulting_engineer':
                    $phone = $http['consulting_engineer'];
                    $form = $http['form'];
                    $this->setOrder($phone, $form);
                    break;
                case 'try_30_day':
                    $phone = $http['try_30_day'];
                    $form = $http['form'];
                    $this->setOrder($phone, $form);
                    break;
                default:'';
            }
        }
        return $http;
		
    }

    public function connect() {

        define('HOST', 'localhost');
        define('USER', 'u_3gstar');
        define('PASSWORD', 'ZunxnNwa');
        define('NAME', '3gstar');

        $connect = mysql_connect(HOST, USER, PASSWORD);
        $db = mysql_select_db(NAME);
    }

    final public function checkout($order, $total, $user) {

        $orders = array();
        $orders_product = array();
        $address_book = array();

        foreach ($user as $item) {
            $phone = $item['userPhone'];
            $orders = array(
                        "customers_name" => $item['userName'],
                        "customers_city" => $item['userName'],
                        "customers_telephone" => $item['userPhone'],
                        "delivery_name" => $item['userName'],
                        "delivery_city" => $item['userName'],
                        "billing_name" => $item['userName'],
                        "billing_city" => $item['userName'],
                        "last_modified" => date("Y-m-d H:i:s"),
                        "date_purchased" => date("Y-m-d H:i:s"),
                        "orders_status" => "1",
                        "currency" => "RUR",
                        "currency_value" => "1.000000",
                        "customers_referer_url" => getenv('HTTP_REFERER'),
                        "shipping_module" => "free_free"
            );

            $address_book = array(
                        "entry_lastname" => $item['userName'],
                        "entry_city" => $item['userName']
            );
        }

        foreach ($order as $item) {
            foreach ($item as $f) {

                $orders_product[] = array(
                            "products_id" => $f['id'],
                            "products_name" => $f['name'],
                            "products_price" => $f['price'],
                            "final_price" => $f['price'],
                            "products_quatity" => $f['count']
                );
            }
        }

        $last_customers_id = mysql_fetch_row(mysql_query("SELECT MAX(`customers_id`) FROM `orders`"));
        $last_orders_id = mysql_fetch_row(mysql_query("SELECT MAX(`orders_id`) FROM `orders`"));

        /* 1-st query */
        $sql1 = "INSERT INTO `address_book` (`customers_id`,`entry_lastname`, `entry_city`) VALUES (" . "'" . ($last_customers_id[0] + 1) . "',";
        $comma = ',';
        $z = 0;
        $length = count($address_book);
        foreach ($address_book as $value) {
            $z++;
            if ($z === $length) {
                $comma = '';
            }
            $sql1 .= "'" . $value . "'" . $comma . "";
        }
        $sql1 .= ");";

        echo $sql1;
        mysql_query($sql1);
        /* 1-st query */

        /* 2-nd query */
        $sql = "INSERT INTO `orders` (`customers_id`,
			`customers_name`,`customers_city`,`customers_telephone`,
			`delivery_name`,`delivery_city`,`billing_name`,`billing_city`,
			`last_modified`,`date_purchased`,`orders_status`,`currency`,
			`currency_value`,`customers_referer_url`,`shipping_module`) 
			VALUES (" . "'" . ($last_customers_id[0] + 1) . "',";
        $comma = ',';
        $i = 0;
        $length = count($orders);
        foreach ($orders as $key => $value) {
            $i++;
            if ($i === $length) {
                $comma = '';
            }
            $sql .= "'" . $value . "'" . $comma . "";
        }
        $sql .= ");";

        echo $sql;
        mysql_query($sql);
        /* 2-nd query */

        /* 3-rd query */
        $y = 0;

        foreach ($orders_product as $value) {
            $coma = ',';
            $len2 = count($orders_product);
            $sql2 = "INSERT INTO `orders_products`(`orders_id`,`products_id`, `products_name`,`products_price`, `final_price`,`products_quantity`) VALUES (" . "'" . ($last_orders_id[0] + 1) . "',";

            foreach ($value as $val) {

                $len = count($value);
                $y++;

                if ($y === $len) {
                    $coma = '';
                }
                $sql2 .= "'" . $val . "'" . $coma . "";
            }
            $y = 0;
            $sql2 .= ");";
            mysql_query($sql2);
        }
        echo $sql2;

        /* 3-rd query */


        /* 4-th query */
        $sql3 = "INSERT INTO `orders_status_history` (`orders_id`,`orders_status_id`,`date_added`, `customer_notified`) VALUES (" . "'" . ($last_orders_id[0] + 1) . "','1','" . date("Y-m-d H:i:s") . "','1');";
        mysql_query($sql3);
        echo $sql3;
        /* 4-th query */

        /* 5-th query */
        $sql4 = "INSERT INTO 
			`orders_total` (
			`orders_id`,`title`,`text`, `value`,
			`class`,`sort_order`
			) VALUES (" . "'" . ($last_orders_id[0] + 1) . "','Стоимость товара'," . $total[0]['total'] . " грн.','" . $total[0]['total'] . "','ot_subtotal','1');";
        mysql_query($sql4);
        echo $sql4;
        /* 5-th query */

        /* 6-th query */
        $sql5 = "INSERT INTO 
			`orders_total` (
			`orders_id`,`title`,`text`, `value`,
			`class`,`sort_order`
			) VALUES (" . "'" . ($last_orders_id[0] + 1) . "','Всего:','<b>" . $total[0]['total'] . " грн.</b>','" . $total[0]['total'] . "','ot_total','800');";
        mysql_query($sql5);
        echo $sql5;
        /* 6-th query */

        //send sms and email
        $order_id = ($last_orders_id[0] + 1);
        $phoneCustomer = $user[0]['userPhone'];
        $nameCustomer = $user[0]['userName'];
        $total = $total[0]['total'];

        $this->sendSMSToCustomer($phoneCustomer, $order_id);
        $this->sendMailToAdmin($orders_product, $nameCustomer, $phone, $order_id, $total);
    }

    public function sendSMSToCustomer($phone, $order_number) {

        $tmp_mess = "Ваш заказ на сайте 3gstar.com.ua #$order_number. Наши менеджеры свяжутся с Вами в ближайшее время.";

        $sms = new SMSclient('0979930355', 'sierra595');
        $sms->sendSMS('3gstar', "$phone", "$tmp_mess");
    }

    public function sendMailToAdmin($orders_product, $nameCustomer, $phone, $order_number, $total) {

        $counter = 0;
        $url = getenv('HTTP_REFERER');
        $subject = "Ваш заказ №" . $order_number . " - " . date("d M Y");
        $to = "order@3gstar.com.ua, programmer3g@gmail.com";
        //$to = "programmer3g@gmail.com";
        $message = "<br/>
		3G Star<br/>
		------------------------------------------------------<br/>
			Покупатель:	" . $nameCustomer . "<br/>
			Телефон: 	" . $phone . "<br/>
			Cтраница с которой пришел клиент:" . $url . "<br/>
			Ваш заказ:<br/>
			------------------------------------------------------<br/>";
        foreach ($orders_product as $value) {
            $counter++;
            $output .= $counter . " . " . $value['products_name'] . " - " . $value['products_quatity'] . "шт. x " . $value['products_price'] . " грн. Сумма: " . $value['products_quatity'] * $value['products_price'] . " грн<br/>";
        }
        $output .= "<br/>
		------------------------------------------------------<br/>
		Общая сума заказа: " . $total . " грн<br/>
		------------------------------------------------------<br/>";
        $message .= $output;
        $message .= "
			Ваш заказ принят! Вы сделали правильный выбор, обратившись в компанию 3Gstar!<br/>
			Наши менеджеры свяжутся с вами в течение часа для уточнения деталей (доставки, оплаты и технических вопросов).<br/>
			Обработка заказов производится в рабочие дни (пн-пт с 8 до 21, сб. с 10 до 18, вс. с 10 до 16)<br/>
			Если вы сделали заказ в нерабочее время или в выходной день, то с вами свяжутся в ближайший рабочий день до 11 часов утра. <br/>
			Дополнительные вопросы вы можете задать по телефону +38(097) 99-303-55.
		";

        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: Компания 3GStar <order@3gstar.com.ua>\r\n";

        $email = mail($to, $subject, $message, $headers);
        if ($email) {
            echo "email sended";
        } else {
            echo "faluire";
        }
    }

    public function setOrder($phone, $form) {

        if ($phone) {

            /* save in reserve */
            $telephone = mysql_escape_string($phone);
            $s_url = getenv('HTTP_REFERER');


            $session_id = session_id();

            mysql_query("
			
				INSERT INTO
					`mailing_list` (`phone`,`url`, `session_id`,`form`) 
				VALUES (
					'" . $telephone . "',
					'" . $s_url . "',
					'" . $session_id . "',
					'" . $form . "'
					)
			");
            /* end save in reserve */

            //google docs
            $sFormID = '1sEDq43Hw2_9vK76fFe_gGTS2RVxenn-HH9xyzYKBA38'; // key (id) of google form 
            $asTableFields = array(// input names in google form
                'form' => 'entry.1723019917',
                'phone' => 'entry.782278901',
                'referer' => 'entry.5199687',
                'gclid' => 'entry.1210714950'
            );

            $sAdditionalData = '';

            $asPostRequestToGoogleForms = array(
                $asTableFields['form'] => $form,
                $asTableFields['phone'] => $telephone,
                $asTableFields['referer'] => getenv('HTTP_REFERER'),
                $asTableFields['gclid'] => $_POST['gclid']
            );
            $sPostRequestToGoogleForms = http_build_query($asPostRequestToGoogleForms);

            $ch = curl_init('https://docs.google.com/forms/d/' . $sFormID . '/formResponse');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
            curl_setopt($ch, CURLOPT_REFERER, 'https://docs.google.com/forms/d/' . $sFormID . '/viewform');
            curl_setopt($ch, CURLOPT_POST, 1);
            // передаем поля формы
            curl_setopt($ch, CURLOPT_POSTFIELDS, $sPostRequestToGoogleForms);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // это необходимо, чтобы cURL не высылал заголовок на ожидание
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }

}

function http($post, $get, $session) {

    $ajax = new Ajax_Hendler();
    if (isset($post)) {
        $ajax->action_index($post);
    } else if (isset($get)) {
        $ajax->action_index($get);
    } else if (isset($session)) {
        $ajax->action_index($session);
    }
}

http($_POST, $_GET, $_SESSION);
