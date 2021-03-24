import mutations from './mutation'
import actions from './action'
import getters from './getter'
import JwtService from "@/common/jwt.service"

const defaultState = {
  all_ranking_points: [],
  ranking_points: {}
};

export default {
  state: defaultState,
  getters,
  actions,
  mutations,
};
