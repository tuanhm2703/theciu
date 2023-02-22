<?php

namespace App\Http\Services\VNPay\src\Models;

class Param {
    const VERSION = "vnp_Version";
    const TMN_CODE = "vnp_TmnCode";
    const AMOUNT = "vnp_Amount";
    const COMMAND = "vnp_Command";
    const CREATE_DATE = "vnp_CreateDate";
    const CURR_CODE = "vnp_CurrCode";
    const IP_ADDRESS = "vnp_IpAddr";
    const URL = 'vnp_Url';
    const HASHSECRET = 'vnp_HashSecret';
    const LOCALE = "vnp_Locale";
    const ORDER_INFO = "vnp_OrderInfo";
    const ORDER_TYPE = "vnp_OrderType";
    const RETURN_URL = "vnp_ReturnUrl";
    const TXN_REF = "vnp_TxnRef";
    const EXPIRE_DATE = "vnp_ExpireDate";
    const BILL_MOBILE = "vnp_Bill_Mobile";
    const BILL_EMAIL = "vnp_Bill_Email";
    const BILL_FIRST_NAME = "vnp_Bill_FirstName";
    const BILL_LAST_NAME = "vnp_Bill_LastName";
    const BILL_ADDRESS = "vnp_Bill_Address";
    const BILL_CITY = "vnp_Bill_City";
    const BILL_COUNTRY = "vnp_Bill_Country";
    const INV_PHONE = "vnp_Inv_Phone";
    const INV_EMAIL = "vnp_Inv_Email";
    const INV_CUSTOMER = "vnp_Inv_Customer";
    const INV_ADDRESS = "vnp_Inv_Address";
    const INV_COMPANY = "vnp_Inv_Company";
    const INV_TAXCODE = "vnp_Inv_Taxcode";
    const INV_TYPE = "vnp_Inv_Type";
    const TRANSACTION_NUMBER = "vnp_TransactionNo";
    const TRANSACTION_STATUS = "vnp_TransactionStatus";
    const RESPONSE_CODE = "vnp_ResponseCode";
    const BANK_COD = 'vnp_BankCode';
    const REQUEST_ID = 'vnp_RequestId';
    const TRANSACTION_TYPE = 'vnp_TransactionType';
    const CREATE_BY = 'vnp_CreateBy';
    const SECURE_HASH = 'vnp_SecureHash';
}
