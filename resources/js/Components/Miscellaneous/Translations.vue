<template>
    <span>{{ __('flash.error') }}</span>
    <span>{{ __('flash.error_not_found') }}</span>
    <span>{{ __('flash.error_no_permission') }}</span>
    <span>{{ __('flash.error_no_company_selected') }}</span>
    <span>{{ __('flash.error_not_enough_credits') }}</span>

    <span>{{ __('flash.user_authenticated') }}</span>

    <span>{{ __('flash.email_verified') }}</span>

    <span>{{ __('flash.company_created') }}</span>
    <span>{{ __('flash.company_updated') }}</span>
    <span>{{ __('flash.company_deleted') }}</span>

    <span>{{ __('flash.location_created') }}</span>
    <span>{{ __('flash.location_updated') }}</span>
    <span>{{ __('flash.location_deleted') }}</span>

    <span>{{ __('flash.comment_created') }}</span>
    <span>{{ __('flash.comment_deleted') }}</span>

    <span>{{ __('flash.order_created') }}</span>
    <span>{{ __('flash.order_updated') }}</span>
    <span>{{ __('flash.order_deleted') }}</span>

    <span>{{ __('flash.order_line_created') }}</span>
    <span>{{ __('flash.order_line_deleted') }}</span>

    <span>{{ __('flash.order_shipment_created') }}</span>

    <span>{{ __('flash.order_lower_than_zero') }}</span>
    <span>{{ __('flash.order_amount_higher_than_credit_balance') }}</span>

    <span>{{ __('flash.quotation_created') }}</span>
    <span>{{ __('flash.quotation_updated') }}</span>
    <span>{{ __('flash.quotation_deleted') }}</span>
    <span>{{ __('flash.quotation_deleted') }}</span>
    <span>{{ __('flash.quotation_deleted') }}</span>

    <span>{{ __('flash.quotation_lower_than_zero') }}</span>

    <span>{{ __('flash.quotation_line_created') }}</span>
    <span>{{ __('flash.quotation_line_deleted') }}</span>

    <span>{{ __('flash.technical_drawing_updated') }}</span>
    <span>{{ __('flash.technical_drawing_deleted') }}</span>

    <span>{{ __('flash.product_created') }}</span>
    <span>{{ __('flash.product_deleted') }}</span>
    <span>{{ __('flash.product_updated') }}</span>

    <span>{{ __('flash.credit_transaction_created') }}</span>

    <span>{{ __('flash.credit_package_bought') }}</span>

    <span>{{ __('flash.credit_package_created') }}</span>
    <span>{{ __('flash.credit_package_updated') }}</span>
    <span>{{ __('flash.credit_package_deleted') }}</span>

    <span>{{ __('flash.transfer_custom_pricing_missing') }}</span>

    <span>{{ __('locale_type.en') }}</span>
    <span>{{ __('locale_type.nl') }}</span>
    <span>{{ __('locale_type.de') }}</span>

    <span>{{ __('transfer_type.cmyk') }}</span>
    <span>{{ __('transfer_type.pms') }}</span>

    <span>{{ __('size_type.mm_0000000100_000010_000010') }}</span>
    <span>{{ __('size_type.mm_0000056000_000280_000200') }}</span>
    <span>{{ __('size_type.mm_0000058000_000580_000100') }}</span>
    <span>{{ __('size_type.mm_0000112000_000280_000400') }}</span>
    <span>{{ __('size_type.mm_0000250000_000500_000500') }}</span>
    <span>{{ __('size_type.mm_0000326400_000680_000480') }}</span>
    <span>{{ __('size_type.mm_0000422500_000650_000650') }}</span>
    <span>{{ __('size_type.mm_0000580000_000580_001000') }}</span>
    <span>{{ __('size_type.mm_0001000000_001000_001000') }}</span>
    <span>{{ __('size_type.mm_0004000000_002000_002000') }}</span>
    <span>{{ __('size_type.mm_0009000000_003000_003000') }}</span>

    <span>{{ __('quotation_status.draft') }}</span>
    <span>{{ __('quotation_status.open') }}</span>
    <span>{{ __('quotation_status.waiting_for_technical_drawing') }}</span>
    <span>{{ __('quotation_status.closed') }}</span>
    <span>{{ __('quotation_status.expired') }}</span>

    <span>{{ __('order_status.review_technical_drawing') }}</span>
    <span>{{ __('order_status.waiting_for_technical_drawing') }}</span>
    <span>{{ __('order_status.in_process') }}</span>
    <span>{{ __('order_status.completed') }}</span>
    <span>{{ __('order_status.canceled') }}</span>

    <span>{{ __('product_status.false') }}</span>
    <span>{{ __('product_status.true') }}</span>

    <span>{{ __('file_upload_type.file') }}</span>
    <span>{{ __('file_upload_type.link') }}</span>

    <span>{{ __('transaction_type.credit_order') }}</span>
    <span>{{ __('transaction_type.order') }}</span>
    <span>{{ __('transaction_type.gift') }}</span>

    <span>{{ __('payment_method_type.bank_transfer') }}</span>
    <span>{{ __('payment_method_type.credits') }}</span>

    <!-- MAIL-->

    <span>{{ __('mail.account_verify_cta') }}</span>
    <span>{{ __('mail.account_verify_line_1') }}</span>
    <span>{{ __('mail.account_verify_title') }}</span>

    <span>{{ __('mail.client_account_created_cta') }}</span>
    <span>{{ __('mail.client_account_created_line_1') }}</span>
    <span>{{ __('mail.client_account_created_line_2') }}</span>
    <span>{{ __('mail.client_account_created_line_3') }}</span>
    <span>{{ __('mail.client_account_created_line_4') }}</span>
    <span>{{ __('mail.client_account_created_line_5') }}</span>
    <span>{{ __('mail.client_account_created_title') }}</span>

    <span>{{ __('mail.general_greeting') }}</span>
    <span>{{ __('mail.general_link_disclaimer') }}</span>
    <span>{{ __('mail.general_salutation') }}</span>

    <span>{{ __('mail.order_in_process_cta') }}</span>
    <span>{{ __('mail.order_in_process_line_1') }}</span>
    <span>{{ __('mail.order_in_process_line_2') }}</span>
    <span>{{ __('mail.order_in_process_line_3') }}</span>
    <span>{{ __('mail.order_in_process_line_4') }}</span>
    <span>{{ __('mail.order_in_process_title') }}</span>

    <span>{{ __('mail.order_pick_up_cta') }}</span>
    <span>{{ __('mail.order_pick_up_line_1') }}</span>
    <span>{{ __('mail.order_pick_up_line_2') }}</span>
    <span>{{ __('mail.order_pick_up_line_3') }}</span>
    <span>{{ __('mail.order_pick_up_title') }}</span>

    <span>{{ __('mail.order_shipped_cta') }}</span>
    <span>{{ __('mail.order_shipped_line_1') }}</span>
    <span>{{ __('mail.order_shipped_line_2') }}</span>
    <span>{{ __('mail.order_shipped_title') }}</span>

    <span>{{ __('mail.quotation_created_cta') }}</span>
    <span>{{ __('mail.quotation_created_line_1') }}</span>
    <span>{{ __('mail.quotation_created_line_2') }}</span>
    <span>{{ __('mail.quotation_created_line_3') }}</span>
    <span>{{ __('mail.quotation_created_title') }}</span>

    <span>{{ __('mail.quotation_received_cta') }}</span>
    <span>{{ __('mail.quotation_received_line_1') }}</span>
    <span>{{ __('mail.quotation_received_line_2') }}</span>
    <span>{{ __('mail.quotation_received_line_3') }}</span>
    <span>{{ __('mail.quotation_received_title') }}</span>

    <span>{{ __('mail.supplier_order_placed_line_1') }}</span>
    <span>{{ __('mail.supplier_order_placed_line_2') }}</span>
    <span>{{ __('mail.supplier_order_placed_title') }}</span>
    <span>{{ __('mail.supplier_order_placed_greeting') }}</span>

    <span>{{ __('mail.technical_drawing_rejected_cta') }}</span>
    <span>{{ __('mail.technical_drawing_rejected_line_1') }}</span>
    <span>{{ __('mail.technical_drawing_rejected_line_2') }}</span>
    <span>{{ __('mail.technical_drawing_rejected_line_3') }}</span>
    <span>{{ __('mail.technical_drawing_rejected_line_4') }}</span>
    <span>{{ __('mail.technical_drawing_rejected_title') }}</span>

    <span>{{ __('mail.technical_drawing_updated_cta') }}</span>
    <span>{{ __('mail.technical_drawing_updated_line_1') }}</span>
    <span>{{ __('mail.technical_drawing_updated_line_2') }}</span>
    <span>{{ __('mail.technical_drawing_updated_line_3') }}</span>
    <span>{{ __('mail.technical_drawing_updated_title') }}</span>

    <!-- MAIL-->

    <span>{{ __('country_type.nl') }}</span>
    <span>{{ __('country_type.be') }}</span>
    <span>{{ __('country_type.de') }}</span>

    <span>{{ __('subscription_type.subscription_1') }}</span>
    <span>{{ __('subscription_type.subscription_2') }}</span>
    <span>{{ __('subscription_type.subscription_3') }}</span>

    <span>{{ __('boolean_type.yes') }}</span>
    <span>{{ __('boolean_type.no') }}</span>

    <span>{{ __('boolean_value.1') }}</span>
    <span>{{ __('boolean_value.0') }}</span>

    <span>{{ __('boolean_value.true') }}</span>
    <span>{{ __('boolean_value.false') }}</span>

    <span>{{ __('with_custom_size.yes') }}</span>
    <span>{{ __('with_custom_size.no') }}</span>

    <span>{{ __('delivery_type.shipping') }}</span>
    <span>{{ __('delivery_type.pick_up') }}</span>

    <span>{{ __('shipment_provider.post_nl') }}</span>
    <span>{{ __('shipment_provider.ups') }}</span>
    <span>{{ __('shipment_provider.other') }}</span>

    <span>{{ __('press_type.cold_panel') }}</span>
    <span>{{ __('press_type.hot_panel') }}</span>

    <span>{{ __('verdict_type.accepted') }}</span>
    <span>{{ __('verdict_type.rejected') }}</span>

    <span>{{ __('industry_type') }}</span>
    <span>{{ __('industry_type.publicity') }}</span>
    <span>{{ __('industry_type.fashion') }}</span>
    <span>{{ __('industry_type.work_clothing') }}</span>
    <span>{{ __('industry_type.sports') }}</span>
    <span>{{ __('industry_type.printing_office') }}</span>
    <span>{{ __('industry_type.other') }}</span>

    <span>{{ __('rejection_reason_type.low_quality') }}</span>
    <span>{{ __('rejection_reason_type.missing_file') }}</span>
    <span>{{ __('rejection_reason_type.incorrect_color') }}</span>
    <span>{{ __('rejection_reason_type.does_not_meet_requirements') }}</span>
    <span>{{ __('rejection_reason_type.waiting_for_technical_drawing') }}</span>

    <span>{{ __('line_type.product') }}</span>
    <span>{{ __('line_type.technical_drawing') }}</span>
    <span>{{ __('line_type.shipping') }}</span>
    <span>{{ __('line_type.low_quantity') }}</span>
    <span>{{ __('line_type.discount') }}</span>
    <span>{{ __('line_type.apparel') }}</span>
    <span>{{ __('line_type.transfer_press') }}</span>
    <span>{{ __('line_type.other') }}</span>
</template>
<script setup>
</script>
