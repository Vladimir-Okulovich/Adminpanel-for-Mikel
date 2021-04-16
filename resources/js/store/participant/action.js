import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    initParticipants(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/participants")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_PARTICIPANTS, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getParticipantById(context, participantId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/participant/" + participantId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_PARTICIPANT, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    createParticipant(context, participantInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/participant/create", participantInfo)
                .then((data) => {
                    resolve(data);
                    toastr.success('Successfully created', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    },
    updateParticipant(context, participantInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.put("api/v1/admin/participant/update", participantInfo)
                .then((data) => {
                    resolve(data);
                    toastr.success('Successfully updated', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    },
    deleteParticipant(context, participantId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.delete("api/v1/admin/participant/delete/" + participantId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_PARTICIPANTS, data)
                    toastr.success('Successfully deleted', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
};

export default actions;