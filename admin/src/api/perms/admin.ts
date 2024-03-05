import request from "@/utils/request"

// 管理员列表
export function adminLists(params: any) {
    return request.get({ url: "/auth/adminapi/lists", params }, { ignoreCancelToken: true })
}
// 管理员列表全部
export function adminAll(params: any) {
    return request.get({ url: "/auth/adminapi/all", params })
}
// 管理员添加
export function adminAdd(params: any) {
    return request.post({ url: "/auth/adminapi/add", params })
}

// 管理员编辑
export function adminEdit(params: any) {
    return request.post({ url: "/auth/adminapi/edit", params })
}

// 管理员删除
export function adminDelete(params: any) {
    return request.post({ url: "/auth/adminapi/delete", params })
}

// 管理员详情
export function adminDetail(params: any) {
    return request.get({ url: "/auth/adminapi/detail", params })
}
