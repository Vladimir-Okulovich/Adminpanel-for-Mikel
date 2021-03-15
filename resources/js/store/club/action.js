import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    initClubs(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/clubs")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_CLUBS, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getClubById(context, clubId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/club/" + clubId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_CLUB, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    createClub(context, clubInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/club/create", clubInfo)
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
    updateClub(context, clubInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.put("api/v1/admin/club/update", clubInfo)
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
    deleteClub(context, clubId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.delete("api/v1/admin/club/delete/" + clubId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_CLUBS, data)
                    toastr.success('Successfully deleted', 'Hello', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
};

export default actions;