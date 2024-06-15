<?php

namespace App\Http\Services\SMSService;

class VietGuysSMSErrorCode {
    const INSUFFICIENT_PARAMETERS = -1; // Chưa truyền đầy đủ tham số
    const SERVER_BUSY = -2; // Máy chủ đang bận
    const USER_ACCOUNT_NOT_FOUND = -3; // Không tìm thấy tài khoản người dùng
    const ACCOUNT_LOCKED = -4; // Tài khoản bị khóa
    const INCORRECT_CREDENTIALS = -5; // Thông tin xác thực chưa chính xác
    const API_FEATURE_NOT_ACTIVATED = -6; // Chưa kích hoạt tính năng gửi qua API
    const IP_ACCESS_RESTRICTED = -7; // IP bị giới hạn truy cập
    const BRAND_NAME_NOT_DECLARED = -8; // Tên thương hiệu chưa khai báo
    const ACCOUNT_OUT_OF_CREDITS = -9; // Tài khoản hết credits gửi tin
    const INVALID_PHONE_NUMBER = -10; // Số điện thoại chưa chính xác
    const PHONE_NUMBER_IN_BLACKLIST = -11; // Số điện thoại nằm trong danh sách từ chối nhận tin
    const DUPLICATE_BRAND_NAME_NOT_DECLARED = -13; // Tên thương hiệu chưa khai báo
    const MESSAGE_TOO_LONG = -14; // Số kí tự vượt quá 459 kí tự (lỗi tin nhắn dài)
    const DUPLICATE_MESSAGE_IN_ONE_MINUTE = -16; // Gửi trùng số điện thoại, thương hiệu, nội dung trong 01 phút
    const AD_KEYWORD_IN_CONTENT = -18; // Nội dung có chứa từ khoá quảng cáo
    const DAILY_MESSAGE_LIMIT_EXCEEDED = -19; // Vượt quá số tin nhắn giớn hạn trong một ngày do kh tự qui định
    const TEMPLATE_NOT_REGISTERED = -20; // Template chưa được đăng ký
    const CONTENT_NOT_OTP = -21; // Nội dung không phải OTP
    const NETWORK_TRANSFER_ERROR = -22; // Lỗi chuyển mạng hoặc brandname chưa được set Telco
    const PRICE_NOT_SET = -23; // Chưa set giá bán
}
