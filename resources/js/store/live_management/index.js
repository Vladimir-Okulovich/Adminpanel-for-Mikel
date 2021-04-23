import mutations from './mutation'
import actions from './action'
import getters from './getter'
import JwtService from "@/common/jwt.service"

const defaultState = {
  participants_competition_category_modality: [],
  category_id: 0,
  modality_id: 0,
  all_round_heats: [],
  round_heats: [],
};

export default {
  state: defaultState,
  getters,
  actions,
  mutations,
};
