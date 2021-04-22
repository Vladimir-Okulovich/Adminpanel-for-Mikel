import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    getParticipantsByCompetitionCategoryModality(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/competition/category-modality/participants", data)
                .then(({data}) => {
                    // console.log(data);
                    context.commit(type.SET_PARTICIPANTS_COMPETITION_CATEGORY_MODALITY, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    unregistParticipantToCompetitionCategoryModality(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/competition/category-modality/participant/unregist", data)
                .then(({data}) => {
                    // console.log(data);
                    context.commit(type.SET_PARTICIPANTS_COMPETITION_CATEGORY_MODALITY, data)
                    toastr.success(data.message, '', {timeout: 5000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
};

export default actions;