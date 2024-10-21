<?php

namespace Dotdigitalgroup\Email\Model\Sync\Integration;

use Dotdigitalgroup\Email\Helper\Config;
use Dotdigitalgroup\Email\Helper\Transactional;
use Dotdigitalgroup\Email\Model\AbandonedCart\Interval;
use Dotdigitalgroup\Email\Model\Email\Template;
use Dotdigitalgroup\Email\Model\Sales\Quote;

interface DotdigitalConfigInterface
{
    public const CONFIGURATION_PATHS = [
        Config::XML_PATH_CONNECTOR_API_ENABLED,
        Config::XML_PATH_CONNECTOR_API_USERNAME,
        Config::XML_PATH_CONNECTOR_SYNC_CUSTOMER_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_GUEST_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_SUBSCRIBER_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_ORDER_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_WISHLIST_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_REVIEW_ENABLED,
        Config::XML_PATH_CONNECTOR_SYNC_CATALOG_ENABLED,
        Config::XML_PATH_CONNECTOR_CUSTOMERS_ADDRESS_BOOK_ID,
        Config::XML_PATH_CONNECTOR_SUBSCRIBERS_ADDRESS_BOOK_ID,
        Config::XML_PATH_CONNECTOR_GUEST_ADDRESS_BOOK_ID,
        Config::XML_PATH_CONNECTOR_SYNC_ALLOW_NON_SUBSCRIBERS,
        Config::XML_PATH_CONNECTOR_MAPPING_LAST_ORDER_ID,
        Config::XML_PATH_CONNECTOR_MAPPING_LAST_QUOTE_ID,
        Config::XML_PATH_CONNECTOR_MAPPING_CUSTOMER_ID,
        Config::XML_PATH_CONNECTOR_MAPPING_CUSTOM_DATAFIELDS,
        Config::XML_PATH_CONNECTOR_MAPPING_CUSTOMER_STORENAME,
        Config::XML_PATH_CONNECTOR_MAPPING_CUSTOMER_TOTALREFUND,
        Config::XML_PATH_CONNECTOR_CUSTOMER_ID,
        Config::XML_PATH_CONNECTOR_CUSTOMER_FIRSTNAME,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LASTNAME,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DOB,
        Config::XML_PATH_CONNECTOR_CUSTOMER_GENDER,
        Config::XML_PATH_CONNECTOR_CUSTOMER_WEBSITE_NAME,
        Config::XML_PATH_CONNECTOR_CUSTOMER_CREATED_AT,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_LOGGED_DATE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_CUSTOMER_GROUP,
        Config::XML_PATH_CONNECTOR_CUSTOMER_REVIEW_COUNT,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_REVIEW_DATE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_ADDRESS_1,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_ADDRESS_2,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_CITY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_STATE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_COUNTRY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_POSTCODE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_TELEPHONE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_ADDRESS_1,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_ADDRESS_2,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_CITY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_STATE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_COUNTRY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_TELEPHONE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_TOTAL_NUMBER_ORDER,
        Config::XML_PATH_CONNECTOR_CUSTOMER_AOV,
        Config::XML_PATH_CONNECTOR_CUSTOMER_TOTAL_SPEND,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_DATE,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_ID,
        Config::XML_PATH_CONNECTOR_CUSTOMER_TOTAL_REFUND,
        Config::XML_PATH_CONNECTOR_CUSTOMER_STORE_NAME_ADDITIONAL,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_INCREMENT_ID,
        Config::XML_PATH_CONNECTOR_CUSTOMER_MOST_PURCHASED_CATEGORY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_MOST_PURCHASED_BRAND,
        Config::XML_PATH_CONNECTOR_CUSTOMER_MOST_FREQUENT_PURCHASE_DAY,
        Config::XML_PATH_CONNECTOR_CUSTOMER_MOST_FREQUENT_PURCHASE_MONTH,
        Config::XML_PATH_CONNECTOR_CUSTOMER_FIRST_CATEGORY_PURCHASED,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_CATEGORY_PURCHASED,
        Config::XML_PATH_CONNECTOR_CUSTOMER_FIRST_BRAND_PURCHASED,
        Config::XML_PATH_CONNECTOR_CUSTOMER_LAST_BRAND_PURCHASED,
        Config::XML_PATH_CONNECTOR_CUSTOMER_SUBSCRIBER_STATUS,
        Config::XML_PATH_CONNECTOR_ABANDONED_PRODUCT_NAME,
        Config::XML_PATH_CONNECTOR_CUSTOMER_BILLING_COMPANY_NAME,
        Config::XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_COMPANY_NAME,
        Config::XML_PATH_CONNECTOR_DYNAMIC_CONTENT_WISHLIST_DISPLAY,
        Config::XML_PATH_CONNECTOR_DYNAMIC_CONTENT_REVIEW_DISPLAY_TYPE,
        Config::XML_PATH_CONNECTOR_SYNC_DATA_FIELDS_STATUS,
        Config::XML_PATH_CONNECTOR_SYNC_DATA_FIELDS_BRAND_ATTRIBUTE,
        Config::XML_PATH_CONNECTOR_IMAGE_TYPES_CATALOG_SYNC,
        Config::XML_PATH_CONNECTOR_IMAGE_TYPES_ABANDONED_CART,
        Config::XML_PATH_CONNECTOR_IMAGE_TYPES_ABANDONED_BROWSE,
        Config::XML_PATH_CONNECTOR_IMAGE_TYPES_DYNAMIC_CONTENT,
        Config::XML_PATH_CONNECTOR_SYNC_ORDER_STATUS,
        Config::XML_PATH_CONNECTOR_CUSTOM_ORDER_ATTRIBUTES,
        Config::XML_PATH_CONNECTOR_SYNC_PRODUCT_ATTRIBUTES,
        Config::XML_PATH_CONNECTOR_SYNC_ORDER_PRODUCT_CUSTOM_OPTIONS,
        Config::XML_PATH_CONNECTOR_DISABLE_NEWSLETTER_SUCCESS,
        Config::XML_PATH_CONNECTOR_DISABLE_CUSTOMER_SUCCESS,
        Config::XML_PATH_CONNECTOR_DYNAMIC_STYLING,
        Config::XML_PATH_CONNECTOR_DYNAMIC_NAME_COLOR,
        Config::XML_PATH_CONNECTOR_DYNAMIC_NAME_FONT_SIZE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_NAME_STYLE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_PRICE_COLOR,
        Config::XML_PATH_CONNECTOR_DYNAMIC_PRICE_FONT_SIZE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_PRICE_STYLE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_LINK_COLOR ,
        Config::XML_PATH_CONNECTOR_DYNAMIC_LINK_FONT_SIZE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_LINK_STYLE ,
        Config::XML_PATH_CONNECTOR_DYNAMIC_DOC_FONT,
        Config::XML_PATH_CONNECTOR_DYNAMIC_DOC_BG_COLOR ,
        Config::XML_PATH_CONNECTOR_DYNAMIC_OTHER_COLOR,
        Config::XML_PATH_CONNECTOR_DYNAMIC_OTHER_FONT_SIZE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_OTHER_STYLE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_COUPON_COLOR,
        Config::XML_PATH_CONNECTOR_DYNAMIC_COUPON_FONT_SIZE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_COUPON_STYLE,
        Config::XML_PATH_CONNECTOR_DYNAMIC_COUPON_FONT,
        Config::XML_PATH_CONNECTOR_DYNAMIC_COUPON_BG_COLOR,
        Config::XML_PATH_CONNECTOR_SYNC_CATALOG_VALUES,
        Config::XML_PATH_CONNECTOR_SYNC_CATALOG_VISIBILITY,
        Config::XML_PATH_CONNECTOR_SYNC_CATALOG_TYPE,
        Config::XML_PATH_CONNECTOR_EMAIL_CAPTURE,
        Config::XML_PATH_CONNECTOR_ABANDONED_CART_LIMIT,
        Config::XML_PATH_CONNECTOR_EMAIL_CAPTURE_NEWSLETTER,
        Config::XML_PATH_CONNECTOR_CONTENT_LINK_ENABLED,
        Config::XML_PATH_CONNECTOR_CONTENT_LINK_TEXT,
        Config::XML_PATH_CONNECTOR_CONTENT_CART_URL,
        Config::XML_PATH_CONNECTOR_CONTENT_LOGIN_URL,
        Config::XML_PATH_CONNECTOR_CONTENT_ALLOW_NON_SUBSCRIBERS,
        Config::XML_PATH_CONNECTOR_AC_AUTOMATION_EXPIRE_TIME,
        Config::XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_CAN_CHANGE_BOOKS,
        Config::XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_SHOW_BOOKS,
        Config::XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_CAN_SHOW_FIELDS,
        Config::XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_SHOW_FIELDS,
        Config::XML_PATH_CONNECTOR_SHOW_PREFERENCES,
        Config::XML_PATH_CONNECTOR_DYNAMIC_CONTENT_LINK_TEXT,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_CUSTOMER,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_SUBSCRIBER,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_ORDER,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_GUEST_ORDER,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_REVIEW,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_WISHLIST,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_ORDER_STATUS,
        Config::XML_PATH_CONNECTOR_AUTOMATION_STUDIO_FIRST_ORDER,
        Config::XML_PATH_REVIEWS_ENABLED,
        Config::XML_PATH_REVIEW_ALLOW_NON_SUBSCRIBERS,
        Config::XML_PATH_REVIEW_STATUS,
        Config::XML_PATH_REVIEW_DELAY,
        Config::XML_PATH_REVIEW_NEW_PRODUCT,
        Config::XML_PATH_REVIEW_CAMPAIGN,
        Config::XML_PATH_AUTOMATION_REVIEW_PRODUCT_PAGE,
        Config::XML_PATH_AUTOMATION_REVIEW_ANCHOR,
        Config::XML_PATH_REVIEWS_FEEFO_LOGON,
        Config::XML_PATH_REVIEWS_FEEFO_REVIEWS,
        Config::XML_PATH_REVIEWS_FEEFO_TEMPLATE,
        Config::XML_PATH_LOSTBASKET_ENROL_TO_PROGRAM_ID,
        Config::XML_PATH_LOSTBASKET_ENROL_TO_PROGRAM_INTERVAL,
        Config::XML_PATH_CONNECTOR_INTEGRATION_INSIGHTS_ENABLED,
        Config::XML_PATH_CONNECTOR_ROI_TRACKING_ENABLED,
        Config::XML_PATH_CONNECTOR_PAGE_TRACKING_ENABLED,
        Config::XML_PATH_CONNECTOR_TRACKING_PROFILE_ID,
        Config::XML_PATH_CONSENT_EMAIL_ENABLED,
        Config::XML_PATH_CONSENT_SUBSCRIBER_TEXT,
        Config::XML_PATH_CONSENT_CUSTOMER_TEXT,
        Config::XML_PATH_CONNECTOR_CLIENT_ID,
        Config::XML_PATH_CONNECTOR_SYNC_LIMIT,
        Config::XML_PATH_CONNECTOR_TRANSACTIONAL_DATA_SYNC_LIMIT,
        Config::XML_PATH_CONNECTOR_ENABLE_SUBSCRIBER_SALES_DATA,
        Config::XML_PATH_CONNECTOR_SYNC_BREAK_VALUE,
        Config::XML_PATH_CONNECTOR_MEGA_BATCH_SIZE_ORDERS,
        Config::XML_PATH_CONNECTOR_MEGA_BATCH_SIZE_CATALOG,
        Config::XML_PATH_CONNECTOR_MEGA_BATCH_SIZE_CONTACT,
        Config::XML_PATH_CONNECTOR_CUSTOM_DOMAIN,
        Config::XML_PATH_CONNECTOR_CUSTOM_AUTHORIZATION,
        Config::XML_PATH_CONNECTOR_ADVANCED_DEBUG_ENABLED,
        Config::XML_PATH_CONNECTOR_DEBUG_API_REQUEST_LIMIT,
        Config::XML_PATH_CONNECTOR_IP_RESTRICTION_ADDRESSES,
        Config::XML_PATH_CONNECTOR_STRIP_PUB,
        Config::XML_PATH_CONNECTOR_SYSTEM_ALERTS_SYSTEM_MESSAGES,
        Config::XML_PATH_CONNECTOR_SYSTEM_ALERTS_EMAIL_NOTIFICATIONS,
        Config::XML_PATH_CONNECTOR_SYSTEM_ALERTS_USER_ROLES,
        Config::XML_PATH_CONNECTOR_SYSTEM_ALERTS_FREQUENCY,
        Config::XML_PATH_CONNECTOR_SYSTEM_ALERTS_EMAIL_NOTIFICATION_TEMPLATE,
        Config::XML_PATH_PWA_URL,
        Config::XML_PATH_CRON_SCHEDULE_CUSTOMER,
        Config::XML_PATH_CRON_SCHEDULE_SUBSCRIBER,
        Config::XML_PATH_CRON_SCHEDULE_GUEST,
        Config::XML_PATH_CRON_SCHEDULE_IMPORTER,
        Config::XML_PATH_CRON_SCHEDULE_REVIEWS,
        Config::XML_PATH_CRON_SCHEDULE_ORDERS,
        Config::XML_PATH_CRON_SCHEDULE_CATALOG,
        Config::XML_PATH_CRON_SCHEDULE_CONSENT,
        Config::XML_PATH_CRON_SCHEDULE_CLEANER,
        Config::XML_PATH_CRON_SCHEDULE_TABLE_CLEANER_INTERVAL,
        Config::PATH_FOR_API_ENDPOINT,
        Config::PATH_FOR_PORTAL_ENDPOINT,
        Config::XML_PATH_TRACKING_SCRIPT_VERSION,
        Template::XML_PATH_DDG_TEMPLATE_NEW_ACCOUNT,
        Template::XML_PATH_DDG_TEMPLATE_NEW_ACCOUNT_CONFIRMATION_KEY,
        Template::XML_PATH_DDG_TEMPLATE_NEW_ACCOUNT_CONFIRMATION,
        Template::XML_PATH_DDG_TEMPLATE_FORGOT_PASSWORD,
        Template::XML_PATH_DDG_TEMPLATE_REMIND_PASSWORD,
        Template::XML_PATH_DDG_TEMPLATE_RESET_PASSWORD,
        Template::XML_PATH_DDG_TEMPLATE_WISHLIST_PRODUCT_SHARE,
        Template::XML_PATH_DDG_TEMPLATE_FORGOT_ADMIN_PASSWORD,
        Template::XML_PATH_DDG_TEMPLATE_SUBSCRIPTION_SUCCESS,
        Template::XML_PATH_DDG_TEMPLATE_SUBSCRIPTION_CONFIRMATION,
        Template::XML_PATH_DGG_TEMPLATE_NEW_ORDER_CONFIRMATION,
        Template::XML_PATH_DDG_TEMPLATE_NEW_ORDER_CONFIRMATION_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_ORDER_UPDATE,
        Template::XML_PATH_DDG_TEMPLATE_ORDER_UPDATE_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_NEW_SHIPMENT,
        Template::XML_PATH_DDG_TEMPLATE_NEW_SHIPMENT_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_INVOICE_UPDATE,
        Template::XML_PATH_DDG_TEMPLATE_UNSUBSCRIBE_SUCCESS,
        Template::XML_PATH_DDG_TEMPLATE_INVOICE_UPDATE_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_NEW_INVOICE,
        Template::XML_PATH_DDG_TEMPLATE_NEW_INVOICE_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_NEW_CREDIT_MEMO,
        Template::XML_PATH_DDG_TEMPLATE_NEW_CREDIT_MEMO_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_CREDIT_MEMO_UPDATE,
        Template::XML_PATH_DDG_TEMPLATE_SHIPMENT_UPDATE,
        Template::XML_PATH_DDG_TEMPLATE_CONTACT_FORM,
        Template::XML_PATH_DDG_TEMPLATE_CREDIT_MEMO_UPDATE_GUEST,
        Template::XML_PATH_DDG_TEMPLATE_SEND_PRODUCT_TO_FRIEND,
        Template::XML_PATH_DDG_TEMPLATE_PRODUCT_STOCK_ALERT,
        Template::XML_PATH_DDG_TEMPLATE_PRODUCT_PRICE_ALERT,
        Transactional::XML_PATH_DDG_TRANSACTIONAL_ENABLED,
        Transactional::XML_PATH_DDG_TRANSACTIONAL_DEBUG,
        Transactional::XML_PATH_DDG_TRANSACTIONAL_HOST,
        Transactional::XML_PATH_DDG_TRANSACTIONAL_PORT,
        Transactional::XML_PATH_DDG_TRANSACTIONAL_USERNAME,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_ENABLED_1,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_ENABLED_2,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_ENABLED_3,
        Interval::XML_PATH_LOSTBASKET_CUSTOMER_INTERVAL_1,
        Interval::XML_PATH_LOSTBASKET_CUSTOMER_INTERVAL_2,
        Interval::XML_PATH_LOSTBASKET_CUSTOMER_INTERVAL_3,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_CAMPAIGN_1,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_CAMPAIGN_2,
        Quote::XML_PATH_LOSTBASKET_CUSTOMER_CAMPAIGN_3,
        Quote::XML_PATH_LOSTBASKET_GUEST_ENABLED_1,
        Quote::XML_PATH_LOSTBASKET_GUEST_ENABLED_2,
        Quote::XML_PATH_LOSTBASKET_GUEST_ENABLED_3,
        Interval::XML_PATH_LOSTBASKET_GUEST_INTERVAL_1,
        Interval::XML_PATH_LOSTBASKET_GUEST_INTERVAL_2,
        Interval::XML_PATH_LOSTBASKET_GUEST_INTERVAL_3,
        Quote::XML_PATH_LOSTBASKET_GUEST_CAMPAIGN_1,
        Quote::XML_PATH_LOSTBASKET_GUEST_CAMPAIGN_2,
        Quote::XML_PATH_LOSTBASKET_GUEST_CAMPAIGN_3
    ];
}
