import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    getCategoryModalityWithPart(context, competitionId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/competition/category-modality-participant/"  + competitionId)
                .then(({data}) => {
                    // console.log(data);
                    context.commit(type.GET_CATEGORY_MODALITY_WITH_PART, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getParticipantsByCompetitionCategoryModality(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/competition/category-modality/participants", data)
                .then(({data}) => {
                    // console.log(data);
                    context.commit(type.SET_PARTICIPANTS_COMPETITION_CATEGORY_MODALITY, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    unregistParticipantToCompetitionCategoryModality(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/competition/category-modality/participant/unregist", data)
                .then(({data}) => {
                    // console.log(data.status);
                    context.commit(type.SET_PARTICIPANTS_AFTER_UNREGIST, data)
                    toastr.success('Participante eliminado Correctamenteamente', '', {timeout: 5000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    createFirstCompetitionBoxes(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/live-management/competition-box/create", data)
                .then((data) => {
                    resolve(data);
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    initCompetitionHeats(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/live-management/competition-heats", data)
                .then(({data}) => {
                    // console.log(data);
                    context.commit(type.GET_ALL_ROUND_HEATS, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    setProgressStatus(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/live-management/competition-heat/progress-status", data)
                .then((data) => {
                    resolve(data);
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    initHeatDetails(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/live-management/competition-heat/heat-details", data)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.GET_ROUND_HEAT_DETAILS, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    storeFinalHeatResults(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/live-management/competition-heat/heat-details/store", data)
                .then((data) => {
                    toastr.success('Guardado Correctamente', '', {timeout: 5000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                    resolve(data);
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },

    initHomeCompetitionHeats(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/competition-heats", data)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.GET_ALL_HOME_ROUND_HEATS, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
};

export default actions;