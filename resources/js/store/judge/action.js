import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    initJudge(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/judge")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.GET_JUDGE_ROUND_HEATS, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    },
    storeHeatResults(context, data) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/judge/store", data)
                .then(({data}) => {
                    toastr.success('Puntuación de Manga salvada. Espere a que se active la siguiente manga', '', {timeout: 5000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                    context.commit(type.SET_ISACTIVESTATUS, data)
                })
                .catch(({ response }) => {
                    // console.log(response);
                });
        });
    }
};

export default actions;