<?php

namespace Domain\Helper\Enums;

enum FlashMessageType: string
{
    case ERROR = 'flash.error';
    case ERROR_NOT_FOUND = 'flash.error_not_found';
    case ERROR_NO_PERMISSION = 'flash.error_no_permission';
    case ERROR_NO_COMPANY_SELECTED = 'flash.error_no_company_selected';

    case USER_AUTHENTICATED = 'flash.user_authenticated';

    case EMAIL_VERIFIED = 'flash.email_verified';

    case COMPANY_CREATED = 'flash.company_created';
    case COMPANY_UPDATED = 'flash.company_updated';
    case COMPANY_DELETED = 'flash.company_deleted';

    case LOCATION_CREATED = 'flash.location_created';
    case LOCATION_UPDATED = 'flash.location_updated';
    case LOCATION_DELETED = 'flash.location_deleted';

    case COMMENT_CREATED = 'flash.comment_created';
    case COMMENT_DELETED = 'flash.comment_deleted';

    case ORDER_CREATED = 'flash.order_created';
    case ORDER_UPDATED = 'flash.order_updated';
    case ORDER_DELETED = 'flash.order_deleted';

    case ORDER_LINE_CREATED = 'flash.order_line_created';
    case ORDER_LINE_DELETED = 'flash.order_line_deleted';

    case ORDER_SHIPMENT_CREATED = 'flash.order_shipment_created';

    case ORDER_LOWER_THAN_ZERO = 'flash.order_lower_than_zero';
    case ORDER_AMOUNT_HIGHER_THAN_CREDIT_BALANCE = 'flash.order_amount_higher_than_credit_balance';

    case QUOTATION_CREATED = 'flash.quotation_created';
    case QUOTATION_UPDATED = 'flash.quotation_updated';
    case QUOTATION_DELETED = 'flash.quotation_deleted';

    case QUOTATION_LOWER_THAN_ZERO = 'flash.quotation_lower_than_zero';

    case QUOTATION_LINE_CREATED = 'flash.quotation_line_created';
    case QUOTATION_LINE_DELETED = 'flash.quotation_line_deleted';

    case TECHNICAL_DRAWING_UPDATED = 'flash.technical_drawing_updated';
    case TECHNICAL_DRAWING_DELETED = 'flash.technical_drawing_deleted';

    case PRODUCT_CREATED = 'flash.product_created';
    case PRODUCT_DELETED = 'flash.product_deleted';
    case PRODUCT_UPDATED = 'flash.product_updated';

    case TRANSFER_CUSTOM_PRICING_MISSING = 'flash.transfer_custom_pricing_missing';

    case CREDIT_TRANSACTION_CREATED = 'flash.credit_transaction_created';

    case CREDIT_PACKAGE_CREATED = 'flash.credit_package_created';
    case CREDIT_PACKAGE_UPDATED = 'flash.credit_package_updated';
    case CREDIT_PACKAGE_DELETED = 'flash.credit_package_deleted';

    case CREDIT_PACKAGE_BOUGHT = 'flash.credit_package_bought';
}
