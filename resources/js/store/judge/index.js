import mutations from './mutation'
import actions from './action'
import getters from './getter'
import JwtService from "@/common/jwt.service"

const defaultState = {
  judge_round_heats: [],
  judge_heat_scores: [],
};

export default {
  state: defaultState,
  getters,
  actions,
  mutations,
};
