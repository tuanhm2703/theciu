<?php

namespace App\Services\Models;

class FirebaseErrorCode {
    static $errorMap = [
        "CREDENTIAL_MISMATCH" => "Lỗi xác thực người dùng",
        "MISSING_CUSTOM_TOKEN" => "Lỗi token không hợp lệ",
        "INVALID_IDENTIFIER" => "Địa chỉ email không hợp lệ",
        "MISSING_CONTINUE_URI" => "Lỗi URI chuyển tiếp thiếu",
        "INVALID_PASSWORD" => "Mật khẩu không đúng",
        "MISSING_PASSWORD" => "Lỗi mật khẩu trống",
        "EMAIL_EXISTS" => "Email đã được sử dụng để đăng ký tài khoản khác",
        "PASSWORD_LOGIN_DISABLED" => "Không cho phép đăng nhập bằng mật khẩu",
        "INVALID_IDP_RESPONSE" => "Phản hồi từ nhà cung cấp dịch vụ xác thực không hợp lệ",
        "INVALID_PENDING_TOKEN" => "Thông tin đang chờ không hợp lệ",
        "FEDERATED_USER_ID_ALREADY_LINKED" => "Tài khoản này đã được liên kết với một tài khoản khác",
        "MISSING_REQ_TYPE" => "Yêu cầu không hợp lệ",
        "EMAIL_NOT_FOUND" => "Không tìm thấy người dùng có địa chỉ email này",
        "RESET_PASSWORD_EXCEED_LIMIT" => "Đã quá số lần yêu cầu đặt lại mật khẩu trong ngày",
        "EXPIRED_OOB_CODE" => "Mã xác minh đã hết hạn",
        "INVALID_OOB_CODE" => "Mã xác minh không hợp lệ",
        "MISSING_OOB_CODE" => "Lỗi mã xác minh trống",
        "CREDENTIAL_TOO_OLD_LOGIN_AGAIN" => "Vui lòng đăng nhập lại để tiếp tục",
        "INVALID_ID_TOKEN" => "Token người dùng không hợp lệ",
        "TOKEN_EXPIRED" => "Token người dùng đã hết hạn",
        "USER_NOT_FOUND" => "Không tìm thấy thông tin người dùng",
        "TOO_MANY_ATTEMPTS_TRY_LATER" => "Đã quá số lần yêu cầu. Vui lòng thử lại sau.",
        "INVALID_CODE" => "Mã xác minh không hợp lệ",
        "INVALID_SESSION_INFO" => "Thông tin phiên làm việc không hợp lệ",
        "INVALID_TEMPORARY_PROOF" => "Bằng chứng tạm thời không hợp lệ",
        "MISSING_SESSION_INFO" => "Lỗi thiếu thông tin phiên làm việc",
        "SESSION_EXPIRED" => "Phiên làm việc đã hết hạn",
        "MISSING_ANDROID_PACKAGE_NAME" => "Tên gói Android trống",
        "UNAUTHORIZED_DOMAIN" => "Tên miền không có quyền truy cập",
        "INVALID_OAUTH_CLIENT_ID" => "ID khách hàng OAuth không hợp lệ",
        "ADMIN_ONLY_OPERATION" => "Yêu cầu chỉ cho admin",
        "INVALID_MFA_PENDING_CREDENTIAL" => "Thông tin xác thực đa yếu tố không hợp lệ",
        "MFA_ENROLLMENT_NOT_FOUND" => "Không tìm thấy thông tin xác thực đa yếu tố",
        "MISSING_MFA_ENROLLMENT_ID" => "ID đăng ký xác thực đa yếu tố không được cung cấp",
        "MISSING_MFA_PENDING_CREDENTIAL" => "Lỗi thiếu thông tin xác thực đa yếu tố",
        "SECOND_FACTOR_EXISTS" => "Người dùng đã có phương pháp xác thực đa yếu tố này",
        "SECOND_FACTOR_LIMIT_EXCEEDED" => "Đã đạt đến giới hạn số lần sử dụng phương pháp xác thực đa yếu tố",
        "BLOCKING_FUNCTION_ERROR_RESPONSE" => "Lỗi chức năng bị chặn"
    ];
    public static function getErrorMessageFromCode(string $key) {
        if (isset(static::$errorMap[$key])) {
            return static::$errorMap[$key];
        }
        return 'Đã có lỗi xảy ra';
    }
}
