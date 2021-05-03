import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.GET_JUDGE_ROUND_HEATS] (state, data) {
    state.judge_round_heats = data.judge_round_heats;
    state.judge_heat_scores = data.judge_heat_scores;
  },
  [type.SET_ISFIRST] (state, data) {
    state.isFirst = false;
  },
};
export default mutations;