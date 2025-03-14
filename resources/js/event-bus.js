import mitt from 'mitt'

// type
export const CLEAR_CREATE_TYPE_VALIDATION = 'CLEAR_CREATE_TYPE_VALIDATION'

// category
export const CLEAR_CREATE_CATEGORY_VALIDATION = 'CLEAR_CREATE_CATEGORY_VALIDATION'

// sub-category
export const CLEAR_CREATE_SUB_CATEGORY_VALIDATION = 'CLEAR_CREATE_CATEGORY_VALIDATION'

// login
export const CLEAR_LOGIN_VALIDATION = 'CLEAR_LOGIN_VALIDATION'

// host
export const UPDATE_HOST_TABLE = 'UPDATE_HOST_TABLE'
export const CLEAR_CREATE_HOST_VALIDATION = 'CLEAR_CREATE_HOST_VALIDATION'
export const UPDATE_AFTER_VERIFY_HOST_ID = 'UPDATE_AFTER_VERIFY_HOST_ID'
export const UPDATE_AFTER_REJECT_HOST_ID = 'UPDATE_AFTER_REJECT_HOST_ID'
export const CLEAR_HOST_REJECT_FIELDS = 'CLEAR_HOST_REJECT_FIELDS'

// listing
export const UPDATE_LISTING_TABLE = 'UPDATE_LISTING_TABLE'
export const CLEAR_CREATE_LISTING_VALIDATION = 'CLEAR_CREATE_LISTING_VALIDATION'
export const CLEAR_LISTING_REJECT_FIELDS = 'CLEAR_LISTING_REJECT_FIELDS'

export const emitter = mitt()
