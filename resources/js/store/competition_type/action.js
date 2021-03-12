import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    initCompetitionTypes(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/competition_types")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_COMPETITION_TYPES, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getCompetitionTypeById(context, competition_typeId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/competition_type/" + competition_typeId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_COMPETITION_TYPE, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    createCompetitionType(context, competition_typeInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/competition_type/create", competition_typeInfo)
                .then((data) => {
                    resolve(data);
                    toastr.success('Successfully created', 'Hello', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    },
    updateCompetitionType(context, competition_typeInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.put("api/v1/admin/competition_type/update", competition_typeInfo)
                .then((data) => {
                    resolve(data);
                    toastr.success('Successfully updated', 'Hello', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    },
    deleteCompetitionType(context, competition_typeId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.delete("api/v1/admin/competition_type/delete/" + competition_typeId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_COMPETITION_TYPES, data)
                    toastr.success('Successfully deleted', 'Hello', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
};

export default actions;