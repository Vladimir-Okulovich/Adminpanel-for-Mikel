import ApiService from "@/api/api.service";
import JwtService from "@/common/jwt.service";
import type from './type';

const actions = {
    initRankingPoints(context) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/all_ranking_points/")
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_RANKING_POINTS, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    getRankingPointsById(context, ranking_pointsId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.get("api/v1/admin/ranking_points/" + ranking_pointsId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_RANKING_POINTS, data)
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
    createRankingPoints(context, ranking_pointsInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.post("api/v1/admin/ranking_points/create", ranking_pointsInfo)
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
    updateRankingPoints(context, ranking_pointsInfo) {
        ApiService.setHeader();
        return new Promise((resolve, reject) => {
            ApiService.put("api/v1/admin/ranking_points/update", ranking_pointsInfo)
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
    deleteRankingPoints(context, ranking_pointsId) {
        ApiService.setHeader();
        return new Promise((resolve) =>{
            ApiService.delete("api/v1/admin/ranking_points/delete/" + ranking_pointsId)
                .then(({data}) => {
                    console.log(data);
                    context.commit(type.SET_ALL_RANKING_POINTS, data)
                    toastr.success('Successfully deleted', 'Hello', {timeout: 1000,closeButton: true,closeMethod: 'fadeOut',closeDuration: 300});
                })
                .catch(({ response }) => {
                    // context.commit(type.AUTH_LOGOUT);
                });
        });
    },
};

export default actions;