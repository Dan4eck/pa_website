Оповещение об оплате на ResultURL
ResultURL предназначен для получения Вашим сайтом оповещения об успешном платеже в автоматическом режиме. В случае успешного проведения оплаты Robokassa делает запрос на ResultURL (см. раздел Технические настройки). Данные всегда передаются в кодировке UTF-8.

Ваш скрипт, находящийся по ResultURL, обязан проверить равенство полученной контрольной суммы и контрольной суммы, рассчитанной Вашим скриптом по параметрам, полученным от Robokassa, а не по локальным данным магазина.

Если контрольные суммы совпали, то Ваш скрипт должен ответить Robokassa, чтобы мы поняли, что Ваш скрипт работает правильно и повторное уведомление с нашей стороны не требуется. Результат должен содержать текст OK и параметр InvId. Например, для номера счёта 5 должен быть вот такой ответ: OK5.

Если контрольные суммы не совпали, то полученное оповещение некорректно, и ситуация требует разбора магазином.

Если в настройках в качестве метода отсылки данных был выбран E-Mail, то в случае успешного проведения оплаты Robokassa отправит Вам письмо на электронный адрес, указанный в поле ResultURL, со всеми выше перечисленными параметрами.

Внимание!
В случае, если вы используете фильтрацию входящих запросов, не забудьте прописать IP-адреса Робокассы в white-лист вашего сервера (185.59.216.65, 185.59.217.65)

Описание параметров

Параметр

Значение

OutSum
Сумма платежа.

InvId
Номер счета в магазине.

Fee
Комиссия Robokassa за совершение операции. Комиссия удерживается согласно тарифу клиента. Таким образом из суммы, оплаченной покупателем (параметр OutSum) вычитается комиссия Robokassa, и на расчетный счет поступит сумма OutSum минус Fee.

EMail
EMail, указанный покупателем в процессе оплаты.

SignatureValue
Контрольная сумма — хэш, число в 16-ричной форме и в верхнем регистре (0-9, A-F), рассчитанное методом указанным в Технических настройках магазина.

База для расчёта контрольной суммы:

если вы не передавали пользовательские параметры OutSum:InvId:Пароль#2

если вы передавали пользовательские параметры OutSum:InvId:Пароль#2:[Пользовательские параметры]

Например, вы передали нам параметры со значениями:

OutSum
100.26
InvId
450009
Shp_login
Vasya
Shp_oplata
1
то база для расчёта контрольной суммы будет выглядеть так:
100.26:450009 :Пароль#2:Shp_login= Vasya :Shp_oplata= 1

PaymentMethod
Способ оплаты который использовал пользователь при совершении платежа.

IncCurrLabel
Валюта, которой платил клиент.

Shp_
Пользовательские параметры, которые возвращаюся вам, если они были переданы при старте платежа.

# result url code example: 

/ as a part of SuccessURL script
        
        // your registration data
        $mrh_pass1 = "securepass1";  // merchant pass1 here
        
        // HTTP parameters:
        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $_REQUEST["InvId"];
        $crc = $_REQUEST["SignatureValue"];
        
        $crc = strtoupper($crc);  // force uppercase
        
        // build own CRC
        $my_crc =  strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
        
        if ($my_crc != $crc)
        {
        echo "bad sign\n";
        exit();
        }
        
        // you can check here, that resultURL was called
          // (for better security)
        
        // OK, payment proceeds
        echo "Thank you for using our service\n";