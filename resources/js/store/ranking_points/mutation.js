import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_ALL_RANKING_POINTS] (state, data) {
    state.all_ranking_points = data.all_ranking_points;
  },
  [type.SET_RANKING_POINTS] (state, data) {
    state.ranking_points = data.ranking_points;
  },
};
export default mutations;