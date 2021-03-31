import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service"
import type from './type'

const actions = {
    initCompetitions(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/competitions")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_COMPETITION, data)
                })
                .catch(({ response }) => {
                    
                });
        });
    },
    getCompetitionById(context, competitionId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/competition/" + competitionId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_COMPETITION, data)
                })
                .catch(({ response }) => {
                    
                });
        });
    },
    createCompetition(context, competitionInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/competition/create", competitionInfo)
                .then((data) => {
                    resolve(data)
                    toastr.success('Successfully created', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    },
    updateCompetition(context, competitionInfo) {
        console.log(competitionInfo)
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.put("api/v1/admin/competition/update", competitionInfo)
                .then((data) => {
                    resolve(data);
                    toastr.success('Successfully updated', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    // console.log(response);
                    reject(response);
                });
        });
    },
    deleteCompetition(context, competitionId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.delete("api/v1/admin/competition/delete/" + competitionId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_COMPETITION, data)
                    toastr.success('Successfully deleted', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    
                });
        });
    },
    createCompetitionToParticipant(context, participantInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/competition/participant/create", participantInfo)
                .then((data) => {
                    resolve(data)
                    toastr.success('Successfully created', '', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({response, status}) => {
                    console.log(response);
                    reject(response);
                });
        });
    }
};


export default actions;