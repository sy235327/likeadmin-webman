import request from '@/utils/request'

// 获取支付方式
export function getPayWay() {
    return request.get({ url: '/setting/pay/payWay/getPayWay' })
}

// 设置支付方式
export function setPayWay(params: any) {
    return request.post({ url: '/setting/pay/payWay/setPayWay', params })
}

// 获取支付方式
export function getPayConfigLists() {
    return request.get({ url: '/setting/pay/payConfig/lists' })
}

// 设置支付方式
export function setPayConfig(params: any) {
    return request.post({ url: '/setting/pay/payConfig/setConfig', params })
}

// 设置支付方式
export function getPayConfig(params: any) {
    return request.get({ url: '/setting/pay/payConfig/getConfig', params })
}
