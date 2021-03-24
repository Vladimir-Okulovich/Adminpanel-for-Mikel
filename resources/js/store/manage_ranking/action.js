import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';
import router from '../../router'

const actions = {
    initCategoryModality(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/manage_ranking/all_category_modality")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_CATEGORY_MODALITY, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getAllRankingData(context, categoryModality) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.post("api/v1/admin/manage_ranking/all_ranking_data", categoryModality)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_RANKING_DATA, data)
                    router.push({name: "ManageRanking"});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    }
};

export default actions;