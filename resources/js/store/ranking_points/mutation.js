import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_ALL_RANKING_POINTS] (state, data) {
    state.all_ranking_points = data.all_ranking_points;
  },
  [type.SET_RANKING] (state, data) {
    state.ranking = data.ranking;
  },
  [type.SET_ALL_RANKINGS] (state, data) {
    state.rankings = data.rankings;
  },
};
export default mutations;